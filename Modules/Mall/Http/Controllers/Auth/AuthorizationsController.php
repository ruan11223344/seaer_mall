<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/10
 * Time: 4:49 PM
 */

namespace Modules\Mall\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Request;
use Illuminate\Support\Str;
use Modules\Mall\Http\Controllers\Shop\ProductsController;
use Modules\Mall\Http\Controllers\UtilsController;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\AuthorizationServer;
use Illuminate\Support\Facades\Auth;
use App\Utils\EchoJson;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request as R;

class AuthorizationsController extends Controller
{
    const LOGIN_FAIL_MAX = 5;
    public $username = null;
    protected $maxAttempts = 2;

    use EchoJson,ThrottlesLogins;


    public function username()
    {
        return $this->username;
    }

    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    protected function throttleKey()
    {
        return Str::lower($this->username.'|'.$this->ip);
    }

    protected function incrementLoginAttempts()
    {
        $this->limiter()->hit(
            $this->throttleKey($this->username,$this->ip), $this->decayMinutes()
        );
    }

    protected function clearLoginAttempts()
    {
        $this->limiter()->clear($this->throttleKey());
    }

    protected function hasTooManyLoginAttempts()
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey(), $this->maxAttempts(), $this->decayMinutes()
        );
    }



    public function getAccessToken(AuthorizationServer $server, ServerRequestInterface $serverRequest)
    {
        $data = $serverRequest->getParsedBody();
        if($data === []){
            return $this->echoErrorJson('错误!参数不能为空!',[]);
        }
        $this->ip = $serverRequest->getServerParams()['REMOTE_ADDR'];
        $this->username = $data['username'];

        if($this->hasTooManyLoginAttempts()){
            $validator = Validator::make($data, [
                'key' => 'required',
                'captcha' => 'required|captcha_api:' . $data['key'],
            ]);

            if ($validator->fails()) {
                return $this->echoErrorJson('验证码验证失败!'.$validator->messages());
            }
        }


        try {
            $token_data = json_decode((string)$server->respondToAccessTokenRequest($serverRequest, new Psr7Response)->withStatus(201)->getBody());
            $data = [
                'token_type'=>$token_data->token_type,
                'expires_in'=>$token_data->expires_in,
                'access_token'=>$token_data->access_token,
                'refresh_token'=>$token_data->refresh_token,
            ];
            $this->clearLoginAttempts();
            return $this->echoSuccessJson('成功!',$data);
        } catch (OAuthServerException $e) {
            $this->incrementLoginAttempts();
            return $this->echoErrorJson($e->getMessage());
        }
    }

    public function getUserInfo()
    {
        $user_obj = Auth::user();
        $user = $user_obj->toArray();
        $company = $user_obj->company->toArray();
        $user_extends = $user_obj->usersExtends->toArray();
        $publish_product = [];
        $publishProductPermissions = ProductsController::getPublishProductPermissions();
        $publish_product['status'] = $publishProductPermissions[0];
        $publish_product['message'] = $publishProductPermissions[1];
        return $this->echoSuccessJson('获取用户信息成功！',compact('user','company','user_extends','publish_product'));
    }


    public function uploadAvatarImg(R $request){
        $data = $request->all();

        Validator::extend('avatar_base64_check', function($attribute, $value, $parameters)
        {
            try{
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            }catch (Exception $e){
                return false;
            }
        });

        $validator = Validator::make($data, [
            'avatar_img_base64'=>'required|avatar_base64_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }
        $img = UtilsController::uploadAvatar($request->input('avatar_img_base64'));
        $img_path = $img['path'];
        $img_url = $img['file_url'];

        $users_extends = Auth::user()->usersExtends;
        $users_extends->update([
           'avatar_url'=>$img_path
        ]);

        return $this->echoSuccessJson('上传头像成功!',['avatar_img_path'=>$img_path,'avatar_img_url'=>$img_url]);
    }

    public function getAvatar(){
        $avatar_url = Auth::user()->usersExtends->avatar_url;

        if($avatar_url == null){
            return $this->echoErrorJson('从未设置过头像！');
        }else{
            $res = [];
            $res['avatar_url'] = UtilsController::getPathFileUrl($avatar_url);
            $res['avatar_path'] = $avatar_url;

            return $this->echoSuccessJson('获取头像成功!',$res);
        }
    }
}