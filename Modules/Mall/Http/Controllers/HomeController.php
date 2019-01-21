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
        return view('mall::index');
    }

    public function test(Request $request)
    {

    }

}
