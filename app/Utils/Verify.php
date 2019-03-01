<?php


namespace App\Utils;

use App\Models\Captcha;
use Illuminate\Http\Request;

class verify
{
    const VERIFY_SUCCESS = 0;
    const VERIFYING = 1;
    const VERIFY_TIMEOUT = 2;

    public function verify($type,$verify_from,$captcha){
        $captcha = Captcha::where('verify_from',$verify_from)->first();
        $response_type = null;
        $response_message = null;
        if($captcha !== null){
            if($captcha->create_at+$captcha->timeout_second > time()){
                $captcha->status = self::VERIFY_SUCCESS;
                $response_status = 0;
                $response_message = '验证Success!';
            }else{
                $response_status = 1;
                $captcha->status = self::VERIFY_TIMEOUT;
                $response_message = '验证超时!请重新发起验证!';
            }
            $captcha->save();
        }else{
            $response_message = '验证失败,该验证不存在!';
        }
    }

    public function createVerify($type,$verify_from,$captcha){

    }
}
