<?php

namespace Modules\Mall\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mews\Captcha\Facades\Captcha;


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ec::index');
    }

    public function test(Request $request){
        return captcha_img('inverse');
    }



    public function test_c(Request $request){
        $rules = [
            "captcha" => 'required|captcha'
        ];
        $messages = [
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码错误,请重试!'
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            return "验证码正确!";
        }


    }

}
