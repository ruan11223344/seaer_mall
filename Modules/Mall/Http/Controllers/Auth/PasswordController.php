<?php

namespace Modules\Mall\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\Captcha;
use Modules\Mall\Entities\User;
use App\Utils\EMail;
use App\Utils\EchoJson;

class PasswordController extends Controller
{
    use EchoJson;

    const RESET_PASSWORD_TOKEN_NORMAL = 0;
    const RESET_PASSWORD_TOKEN_ING = 1;
    const RESET_PASSWORD_TOKEN_FAIL = 2;
    const RESET_PASSWORD_TOKEN_OVER = 3;


    public function sendResetPasswordEmail(Request $request){
        $data = $request->all();

        Validator::extend('member_id_or_email_check', function($attribute, $value, $parameters,$validator)
        {
            if(User::where('name',$value)->orWhere('email',$value)->exists()){
                return true;
            }else{
                $validator->setCustomMessages(['member_id_or_email_check' => 'can\'t found member_id or email!']);
                return false;
            }
        });

        $validator = Validator::make($data,[
            'member_id_or_email'=>'required|member_id_or_email_check',
            'key' => 'required',
            'captcha' => 'required|captcha_api:' . $data['key'],
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $member_id_or_email =  $request->input('member_id_or_email');

        $user_obj = User::where('name',$member_id_or_email)->orWhere('email',$member_id_or_email)->first();

        $email_obj = new EMail();
        $subject = 'Reset Your Afriby.com Password.';

        $encrypt_password_token = self::encryptPasswordToken($user_obj);
        try{
            $email_obj->send(
                $user_obj->email,
                $subject,
                [
                    'reset_password_url'=>self::resetPasswordUrl($encrypt_password_token),
                    'logo_url'=>asset('/img/logo.png'),
                ],
                $email_obj::TEMPLATE_PASSWORD_RESET
            );
            $res = self::storePasswordToken($encrypt_password_token,$user_obj);
            if($res == false){
                throw new Exception('验证信息入库失败!');
            }
        }catch (Exception $e){
            return $this->echoErrorJson('发送重置密码邮件失败! 错误信息: '.$e->getMessage());
        }
        return $this->echoSuccessJson('发送重置密码邮件成功!',['redirect_to'=>EMail::foundEmailUrl($user_obj->email)]);
    }

    public static function storePasswordToken($encrypt_password_token,$user_obj){
        $res = Captcha::create(
            [
                'user_id'=>$user_obj->id,
                'type'=>'email',
                'captcha'=>$encrypt_password_token,
                'status'=>self::RESET_PASSWORD_TOKEN_NORMAL,
                'timeout_second'=>24*60*60,
                'verify_from'=>'reset_password_by_email',
            ]
        );
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public static function encryptPasswordToken($user_obj){
        $str = $user_obj->id.'-'.$user_obj->email.'-'.$user_obj->name.'-'.time();
        $encrypt = md5($str);
        return $encrypt;
    }

    public static function resetPasswordUrl($encrypt_password_token)
    {
        return route('password.reset').'?token='.$encrypt_password_token;
    }

    public function getResetPasswordMemberId(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'token'=>'required|exists:captcha,captcha',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }
        $token = $request->input('token');

        $token_obj = Captcha::where(['captcha'=>$token,'verify_from'=>'reset_password_by_email'])->first();

        if($token_obj->exists() && $token_obj->status == self::RESET_PASSWORD_TOKEN_NORMAL){
            $user_obj = User::find($token_obj->user_id)->first();
            $token_obj->status = self::RESET_PASSWORD_TOKEN_ING;
            $token_obj->save();

            self::forgetUserCaptcha($token_obj);

            return $this->echoSuccessJson('获取member_id成功!',['member_id'=>$user_obj->name]);
        }else{
            return $this->echoErrorJson('获取member_id失败!该token被访问过一次了,已失效!');
        }
    }

    public static function forgetUserCaptcha($token_obj,$forget_all = false){
        $captcha_obj = Captcha::where(
            [
                'user_id'=>$token_obj->user_id,
                'verify_from'=>'reset_password_by_email',
            ]
        );


        if($forget_all == false){
           $captcha_obj =  $captcha_obj->where('captcha','!=',$token_obj->captcha);
        }

        $captcha_obj->get()->map(function ($value, $key){
            $value->status = self::RESET_PASSWORD_TOKEN_FAIL;
            $value->save();
        });
    }

    public function resetPassword(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'token'=>'required|exists:captcha,captcha',
            'password'=>'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $token = $request->input('token');

        $token_obj = Captcha::where(['captcha'=>$token,'verify_from'=>'reset_password_by_email'])->first();


        if($token_obj->exists() && $token_obj->status == self::RESET_PASSWORD_TOKEN_ING){
            if(($token_obj->timeout_second + Carbon::parse($token_obj->created_at)->timestamp) > time()){
                $password = $request->input('password');
                $user_obj = User::find($token_obj->user_id)->first();
                $new_password = bcrypt($password);
                $user_obj->update(
                    ['password'=>$new_password]
                );
                $carbon = Carbon::now()->toDateTimeString();
                DB::insert("insert into password_resets (email, token,created_at) values ('$user_obj->email','$new_password','$carbon')");
                self::forgetUserCaptcha($token_obj,true);
                return $this->echoSuccessJson('恭喜!重置密码成功!');
            }else{
                self::forgetUserCaptcha($token_obj,true);
                return $this->echoErrorJson('重置失败!token过期!');
            }
        }else{
            self::forgetUserCaptcha($token_obj,true);
            return $this->echoErrorJson('错误!token已失效!');
        }
    }

    public function getResetPasswordUrl(){
        return redirect('http://'.env('MALL_DOMAIN').'/auth/reset_password?'); //前端路由
    }

}
