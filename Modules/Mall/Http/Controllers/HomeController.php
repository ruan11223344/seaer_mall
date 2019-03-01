<?php

namespace Modules\Mall\Http\Controllers;

use App\Utils\EchoJson;
use Illuminate\Routing\Controller;
use Modules\Mall\Entities\Products;
use Modules\Mall\Http\Controllers\Shop\ProductsController;


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

    public function getIndex()
    {
        $data = [];

        $data['ad_slides_url_list'] = [
            ['image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'],
            ['image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'],
            ['image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'],
            ['image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'],
        ];
        $data['ad_header_url'] = [
            'image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'
        ];
        $data['ad_three_url_list'] = [
            ['image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'],
            ['image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'],
            ['image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'],
        ];
        $data['ad_center_url'] = [
            'image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'
        ];
        $data['ad_bottom_url'] = [
            'image_url'=>'https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/album/155072840888932208.png','jump_url'=>'http://www.qq.com'
        ];
        $p_data = ProductsController::getProductFormatInfo(Products::limit(10));
        $data['product_personal_recommend'] = $p_data;
        $data['product_hot_recommend'] = $p_data;
        $data['product_history'] = ProductsController::getProductFormatInfo(Products::limit(20));

        return $this->echoSuccessJson('Success!',$data);
    }

}
