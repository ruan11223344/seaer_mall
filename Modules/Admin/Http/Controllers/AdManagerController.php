<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Ad;
use App\Utils\EchoJson;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Entities\IndexProductRecommend;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\Products;

class AdManagerController extends Controller
{
    use EchoJson;

    public static function getAdData(){
        $slide = [];
        $banner = [];
        Ad::get()->map(function ($v)use(&$slide,&$banner){
            $tmp = [];
            $tmp['ad_id'] = $v->id;
            $tmp['ad_name'] = $v->ad_name;
            $tmp['width'] = $v->width;
            $tmp['height'] = $v->width;
            $tmp['jump_url'] = $v->jump_url;
            $tmp['image_path'] = $v->image_path;
            $tmp['image_url'] = \Modules\Mall\Http\Controllers\UtilsController::getPathFileUrl($v->image_path);
            $tmp['enabled'] = $v->enabled;

            if($v->is_slide == true){
                array_push($slide,$tmp);
            }else{
                array_push($banner,$tmp);
            }
        });

        $res_data['slide'] = $slide;
        $res_data['banner'] = $banner;
        return $res_data;
    }

    public function getAdList(){
        $res_data = self::getAdData();
        return $this->echoSuccessJson('获取成功!',$res_data);
    }

    public function editAd(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'ad_id'=>'required|exists:ad,id',
            'ad_name'=>'required',
            'jump_url'=>'nullable',
            'image_path'=>'required',
            'enabled'=>'boolean|required',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $ad = Ad::find($request->input('ad_id'));

        if($ad == null){
            return $this->echoErrorJson('这条广告记录不存在!');
        }


        $jump_url = $request->input('jump_url',null);
        if($jump_url == null && isset($data['jump_url'])){
            unset($data['jump_url']);
        }

        $res = $ad->update($data);

        if($res){
            return $this->echoSuccessJson('编辑更新成功!');
        }else{
            return $this->echoErrorJson('编辑更新失败!');
        }



    }

    public static function getIndexProductRecommendData(){
        $product_arr = IndexProductRecommend::all()->pluck('product_id');
        $res_data = [];
        Products::whereIn('id',$product_arr)->get()->map(function ($item)use(&$res_data){
            $tmp = [];
            $tmp['index_product_recommend_id'] = IndexProductRecommend::where('product_id',$item->id)->get()->first()->id;
            $tmp['product_name'] = $item->product_name;
            $tmp['product_id'] = $item->id;
            $tmp['shop_name'] = Company::find($item->company_id)->company_name;
            $tmp['upload_time'] = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');

            array_push($res_data,$tmp);
        });
        return $res_data;
    }

    public function getIndexProductRecommend(){
        $res_data = self::getIndexProductRecommendData();
        return $this->echoSuccessJson("获取首页推荐商品成功!",$res_data);
    }


    public function editIndexProductRecommend(Request $request){
        $data =  $request->all();
        $validator = Validator::make($data,[
            'index_product_recommend_id'=>'required|exists:index_product_recommend,id',
            'product_id'=>'required|exists:products,id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $index_product_recommend_id = $request->input('index_product_recommend_id');
        $product_id = $request->input('product_id');
        $index_product_recommend = IndexProductRecommend::find($index_product_recommend_id);
        $index_product_recommend->update(
            [
                'product_id'=>$product_id
            ]
        );

        return $this->echoSuccessJson('更新成功!',self::getIndexProductRecommendData());
    }


}