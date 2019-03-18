<?php

namespace Modules\Mall\Http\Controllers;

use App\Utils\EchoJson;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\UserLog;
use Modules\Admin\Http\Controllers\AdManagerController;
use Modules\Mall\Entities\Products;
use Modules\Mall\Http\Controllers\Shop\ProductsController;
use Illuminate\Http\Request;

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

    public function getAdInfo(){
        $res_data = AdManagerController::getAdData();
        return $this->echoSuccessJson('获取成功!',$res_data);
    }

    public function getIndexProductRecommend(Request $request){
        $user_id = $request->input('user_id',null);
        $index_product = AdManagerController::getIndexProductRecommendData();
        $product_id_list = [];
        foreach ($index_product as $v){
            $product_id_list[] = $v['product_id'];
        }

        $product_orm = Products::whereIn("id",$product_id_list);

        $product_data = [];

        $product_data['hot_recommend'] = ProductsController::getProductFormatInfo($product_orm);

        if($user_id == null){
            $product_data['personal_recommend'] = ProductsController::getProductFormatInfo(Products::whereNotIn('id',$product_id_list)->orderBy(\DB::raw('RAND()'))->take(10));
        }else{
            $log_company_id_list = UserLog::where([
                ['user_id','=',$user_id],
                ['type','=','company'],
                ['action','=','visit']
            ])->pluck('type_for_id');
            $log_product_id_list = UserLog::where([
                ['user_id','=',$user_id],
                ['type','=','product'],
                ['action','=','visit']
            ])->pluck('type_for_id');

            $categories_id_list = Products::whereIn('id',$log_product_id_list)->pluck('product_categories_id');
            $company_list = Products::whereIn('id',$log_product_id_list)->pluck('company_id');
            $company_arr = array_merge($company_list,$log_company_id_list);

            $p_orm = Products::whereIn('company_id',$company_arr)->whereIn('product_categories_id',$categories_id_list)->whereNotIn('id',$product_id_list)->orderBy(\DB::raw('RAND()'))->take(10);

            $product_data['personal_recommend'] = ProductsController::getProductFormatInfo($p_orm);
        }

        return $this->echoSuccessJson('获取推荐商品成功!',$product_data);
    }

}
