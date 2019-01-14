<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/14
 * Time: 1:39 PM
 */

namespace Modules\Mall\Http\Controllers;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mews\Captcha\Captcha;

class CaptchaController extends Controller
{
    use EchoJson;
    public function getCaptcha(){
        return $this->echoSuccessJson('获取验证码成功!',app('captcha')->create('default', true));
    }

    public function checkCaptchaUrl(Request $request){
        if (!captcha_api_check($request->captcha, $request->key)){
            return $this->echoErrorJson('验证码验证失败!');
        }
        return $this->echoSuccessJson('验证码验证成功!');
    }

    public static function checkCaptcha($captcha,$key){
        if (!captcha_api_check($captcha, $key)){
            return false;
        }else{
            return true;
        }
    }
}