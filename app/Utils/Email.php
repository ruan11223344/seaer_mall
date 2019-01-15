<?php

namespace App\Utils;

use Illuminate\Support\Facades\Facade;
use Modules\Mall\Entities\MailRecored;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class EMail
{
    const TEMPLATE_REGISTER = 'register';
    const TEMPLATE_PASSWORD_RESET = 'password_reset';
    const TEMPLATE_TEST = 'test';

    const STATUS_SUCCESS = 0;
    const STATUS_ERROR = 1;

    public static $email_address = [
        'qq.com'=>'http://mail.qq.com',
        'gmail.com'=>'http://mail.google.com',
        'sina.com'=>'http://mail.sina.com.cn',
        '163.com'=>'http://mail.163.com',
        '126.com'=>'http://mail.126.com',
        'yeah.net'=>'http://www.yeah.net/',
        'sohu.com'=>'http://mail.sohu.com/',
        'tom.com'=>'http://mail.tom.com/',
        'sogou.com'=>'http://mail.sogou.com/',
        '139.com'=>'http://mail.10086.cn/',
        'hotmail.com'=>'http://www.hotmail.com',
        'live.com'=>'http://login.live.com/',
        'live.cn'=>'http://login.live.cn/',
        'live.com.cn'=>'http://login.live.com.cn',
        '189.com'=>'http://webmail16.189.cn/webmail/',
        'yahoo.com.cn'=>'http://mail.cn.yahoo.com/',
        'yahoo.cn'=>'http://mail.cn.yahoo.com/',
        'eyou.com'=>'http://www.eyou.com/',
        '21cn.com'=>'http://mail.21cn.com/',
        '188.com'=>'http://www.188.com/',
        'foxmail.com'=>'http://www.foxmail.com',
        'outlook.com'=>'http://www.outlook.com',
    ];

    public function send($to, $subject, $data, $template_name,$user_id = null) //$data 是一个关联数组 用于模板赋值。
    {
        if($user_id === null){
            if(Auth::check()){
                $user_id = Auth::user()->id;
            }
        }

        try{
            Mail::send('emails.'.$template_name, $data, function ($message) use ($to, $subject) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'))->to($to)->subject($subject);
                }
            );
            Log::info('邮件发送成功'.'用户邮箱:'.$to);
            $this->recoredMail($user_id,$to,$template_name,self::STATUS_SUCCESS);
            return true;
        }catch (Exception $ex){
            dd($ex->getMessage());
            Log::error('邮件发送错误:'.$ex->getMessage());
            $this->recoredMail($user_id,$to,$template_name,self::STATUS_ERROR);
            return false;
        }
    }

    public function recoredMail($user_id,$to,$template_name,$status){
        $model = new MailRecored();
        $model->user_id = $user_id;
        $model->to = $to;
        $model->template_name = $template_name;
        $model->status = $status;
        $model->save();
    }

    public static function foundEmailUrl($email){
        $last = explode('@',$email)[1];
         if(array_key_exists($last,self::$email_address)){
             return self::$email_address[$last];
         }else{
             return null;
         }
    }
}
