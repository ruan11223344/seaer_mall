<?php

namespace Modules\Mall\Http\Controllers;
use App\Utils\City;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mews\Captcha\Facades\Captcha;


class HomeController extends Controller
{
    use EchoJson;
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
        dd(substr('3c339550-17e0-11e9-aaf7-373fe9a5c52b',0,8));
        return $this->echoSuccessJson('',(array)City::getCityList(125));
    }

}
