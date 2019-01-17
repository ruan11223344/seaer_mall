<?php

namespace Modules\Mall\Http\Controllers;
use App\Utils\City;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mews\Captcha\Facades\Captcha;
use Khsing\World\Models\Country;
use Modules\Mall\Entities\ProductsCategories;
use Modules\Mall\Entities\RegisterTemp;


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
        $name = Auth::user()->name;
        return view('home',['name'=>$name]);
    }

    public function test(Request $request){
        dd(RegisterTemp::where('register_uuid','=','08b7b510-18a3-11e9-bc7a-db13b186ec35')->orderBy('created_at','desc')->first()->name);
        $root = ProductsCategories::descendantsAndSelf(1)->toTree()->first()->toArray();
        dd($root);
        return $this->echoSuccessJson('',(array)City::getCityList(125));
    }

}
