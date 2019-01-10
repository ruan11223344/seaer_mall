<?php

namespace Modules\Mall\Http\Controllers;

use Illuminate\Routing\Controller;


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
}
