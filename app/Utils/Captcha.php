<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/14
 * Time: 10:42 AM
 */
namespace App\Utils;

class Captcha{
    public static function getCaptchaUrl(){
       return app('captcha')->create('default', true);
    }

    public function checkCaptcha(){
    }

    public function myCaptchaPost(Request $request)
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ],
            ['captcha.captcha'=>'Invalid captcha code.']);
        dd("You are here :) .");
    }
}