<?php

namespace Modules\Mall\Http\Controllers;
use App\Utils\City;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mews\Captcha\Facades\Captcha;
use Khsing\World\Models\Country;
use Modules\Mall\Entities\ProductsCategories;


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
        $root = ProductsCategories::descendantsAndSelf(1)->toTree()->first()->toArray();
        dd($root);
        return $this->echoSuccessJson('',(array)City::getCityList(125));
    }

}
