<?php

namespace App\Http\Controllers;

use App\Models\MailRecored;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailController extends Controller
{
    const REGISTER = 'register';
    const PASSWORD_RESET = 'password_reset';
    const TEST = 'test';

    const STATUS_SUCCESS = 0;
    const STATUS_ERROR = 1;

    public function send($to, $subject, $name, $template_name,$user_id = null)
    {
        if($user_id === null){
            if(Auth::check()){
                $user_id = Auth::user()->id;
            }
        }


        try{
            Mail::send('emails.'.$template_name, ['name' => $name], function ($message) use ($to, $subject) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'))->to($to)->subject($subject);
                }
            );
            Log::info('邮件发送成功'.'用户邮箱:'.$to);
            $this->recoredMail($user_id,$to,$template_name,self::STATUS_SUCCESS);
        }catch (Exception $ex){
            Log::error('邮件发送错误:'.$ex->getMessage());
            $this->recoredMail($user_id,$to,$template_name,self::STATUS_ERROR);
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
}
