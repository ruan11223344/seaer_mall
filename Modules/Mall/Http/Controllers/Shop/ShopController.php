<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers\Shop;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\Shop;
use Modules\Mall\Http\Controllers\UtilsController;

class ShopController extends Controller
{
    use EchoJson;
    public function setShopBanner(Request $request){
        $data = $request->all();

        Validator::extend('banner_base64_check', function($attribute, $value, $parameters)
        {
            try{
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            }catch (Exception $e){
                return false;
            }
        });

        $validator = Validator::make($data, [
            'banner_img_base64'=>'required|banner_base64_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $img = UtilsController::uploadFilesByBase64([$request->input('banner_img_base64')]);

        $img_path = $img[0]['path'];
        $img_url = $img[0]['file_url'];

        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);

        if($shop_obj->exists()){
            $shop_obj->get()->first()->update([
               'banner_url'=>$img_path
            ]);
        }else{
            Shop::create([
                'company_id'=>$company_id,
                'banner_url'=>$img_path,
            ]);
        }

        return $this->echoSuccessJson('更新成功!',['img_path'=>$img_path,'img_url'=>$img_url]);
    }

    public function getShopBanner(){
        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);

        if($shop_obj->exists()){
            $shop_obj  = $shop_obj->get()->first();
            if($shop_obj->banner_url == null){
                return $this->echoErrorJson('错误!没有设置过banner!');
            }
            return $this->echoSuccessJson('获取banner成功!',['banner_path'=>$shop_obj->banner_url,'banner_url'=>UtilsController::getPathFileUrl($shop_obj->banner_url)]);
        }else{
            return $this->echoErrorJson('错误!没有设置过banner!');
        }
    }

    public function deleteShopBanner(){
        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);

        if($shop_obj->exists()){
            $shop_obj  = $shop_obj->get()->first();
            $shop_obj->banner_url = null;
            $shop_obj->save();
        }

        return $this->echoSuccessJson('删除banner成功!');
    }

    public function setSlides(Request $request){
        $data = $request->all();

        Validator::extend('slide_list_check', function($attribute, $value, $parameters,$validator)
        {
            if(is_array($value)){
                $path = UtilsController::getUserShopDirectory();
                $site_domain = env('MALL_DOMAIN');
                foreach ($value as $v){
                    if(!(isset($v['url_path']) && isset($v['sort']))){
                        $validator->setCustomMessages(['slide_list_check' => 'The lack of object!']);
                        return false;
                    }

                    if(stripos($v['url_path'],$path) === false){
                        $validator->setCustomMessages(['slide_list_check' => 'image path error']);
                        return false;
                    }

                    if($v['url_jump'] != null){
                        if(stripos($v['url_jump'],$site_domain) === false){
                            $validator->setCustomMessages(['slide_list_check' => 'Cannot set other domain!']);
                            return false;
                        }
                    }
                }
                return true;
            }else{
                return false;
            }
        });

        $validator = Validator::make($data, [
            'slides_list'=>'array|slide_list_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }


        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);
        $input_slides_url_list = $request->input('slides_list');
        if($shop_obj->exists()){
            $slides_url_list = $shop_obj->get()->first()->slides_url_list;

            if($slides_url_list != null){
                $db_sort_list = array_column($slides_url_list,'sort');
                foreach ($input_slides_url_list as $k=>$v){
                    foreach ($slides_url_list as $kk=>$vv){
                        if($v['sort'] == $vv['sort']){
                            $slides_url_list[$kk] = $v;
                        }elseif (!in_array($v['sort'],$db_sort_list)){
                            if(!in_array($v,$slides_url_list)){
                                array_push($slides_url_list,$v);
                            }
                        }
                    }
                }
                $re_order =array_column($slides_url_list,'sort');
                array_multisort($re_order,SORT_ASC, $slides_url_list);
            }

            
            $shop_obj->get()->first()->update([
                'slides_url_list'=>$slides_url_list == null ? $input_slides_url_list : $slides_url_list
            ]);
        }else{
            Shop::create([
                'company_id'=>$company_id,
                'slides_url_list'=>$input_slides_url_list,
            ]);
        }

        return $this->echoSuccessJson('设置幻灯图片成功!');
    }

    public function uploadSlide(Request $request){
        $data = $request->all();

        Validator::extend('slide_base64_check', function($attribute, $value, $parameters)
        {
            try{
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            }catch (Exception $e){
                return false;
            }
        });

        $validator = Validator::make($data, [
            'slide_img_base64'=>'required|slide_base64_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $img = UtilsController::uploadFilesByBase64([$request->input('slide_img_base64')]);
        return $this->echoSuccessJson('上传成功!',['img_path'=>$img[0]['path'],'img_url'=>$img[0]['file_url']]);
    }

    public function getSlidesList(){
        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);
        if($shop_obj->exists()){
            $shop_obj = $shop_obj->get()->first();
            if($shop_obj->slides_url_list == null){
                return $this->echoErrorJson('获取店铺幻灯片失败!未设置幻灯片!');
            }else{
                $res_data = $shop_obj->slides_url_list;
                foreach ($res_data as $k=>$v){
                    $res_data[$k]['url'] = UtilsController::getPathFileUrl($v['url_path']);
                }
                return $this->echoSuccessJson('获取幻灯片列表成功!',$res_data);
            }
        }else{
            return $this->echoErrorJson('获取店铺幻灯片失败!未设置幻灯片!');
        }
    }

    public function getRecommendProductList(){
        $company_id = Auth::user()->company->id;
        $shop = Shop::where('company_id',$company_id);
        $res = [];
        $product_id_list = [];
        if($shop->exists()){
           $shop_obj =  $shop->get()->first();
           if($shop_obj->recommend_product != null){
               $product_arr = $shop_obj->recommend_product;
               $product_obj= Products::where('company_id',$company_id)->whereIn('id',$product_arr);
               if($product_obj->count() > 0){
                   $res = ProductsController::getProductFormatInfo($product_obj);
                   $product_id_list = $product_obj->get()->pluck('id')->toArray();
               }
           }
        }
        return $this->echoSuccessJson('获取商品推荐列表成功!',['product_info_list'=>$res,'recommend_product_id_list'=>$product_id_list]);
    }

    public function searchRecommendProduct(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'product_name'=>'nullable',
            'sku'=>'nullable',
            'product_origin_id'=>'nullable',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }
        $company_id = Auth::user()->company->id;

        $orm_obj = Products::where('company_id',$company_id);

        $product_name = $request->input('product_name');
        $product_id = $request->input('product_origin_id');
        $sku = $request->input('sku');

        if($product_name != null){
            $product_name_obj = $orm_obj->where('product_name', 'like','%'.$product_name.'%')->get()->toArray();
        }else{
            $product_name_obj = [];
        }

        if($product_id != null){
            $product_id_obj = $orm_obj->where('product_origin_id', $product_id)->get()->toArray();
        }else{
            $product_id_obj = [];
        }

        if($sku != null){
            $product_sku_no = $orm_obj->where('product_sku_no', $sku)->get()->toArray();
        }else{
            $product_sku_no = [];
        }

        $product_id_res = array_merge($product_name_obj,$product_id_obj,$product_sku_no);

        $unique_product_id = array_unique(array_column($product_id_res,'id'));

        $product_obj = Products::whereIn('id',$unique_product_id);

        if($product_obj->count() > 0){
            $res = ProductsController::getProductFormatInfo($product_obj);
        }else{
            return $this->echoErrorJson('没有搜索到结果!');
        }

        return $this->echoSuccessJson('获取搜索结果成功!',['search_res_product_info_list'=>$res]);
    }

    public function setRecommendProductList(Request $request){
        $data = $request->all();

        Validator::extend('product_id_list_check', function($attribute, $value, $parameters,$validator)
        {
            foreach ($value as $v){
                $p_item = Products::find($v);
                if($p_item == null){
                    $validator->setCustomMessages(['product_id_list_check' => 'can\'t found product_id id:'.$v]);
                    return false;
                }

                if($p_item->company_id != Auth::user()->company->id){
                    $validator->setCustomMessages(['product_id_list_check' => 'product_id not your company id:'.$v]);
                    return false;
                }

                if($p_item->product_status != 1 || $p_item->product_audit_status !=1){
                    $validator->setCustomMessages(['product_id_list_check' => 'product_id not sell id:'.$v]);
                    return false;
                }

            }
            return true;
        });

        $validator = Validator::make($data, [
            'product_id_list'=>'required|array|product_id_list_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $product_id_list = $request->input('product_id_list');

        $company_id = Auth::user()->company->id;
        $shop_obj = Shop::where('company_id',$company_id);



        if($shop_obj->exists()){
            $res = $shop_obj->get()->first()->update([
                'recommend_product'=>$product_id_list
            ]);
        }else{
            $res = Shop::create([
                'company_id'=>$company_id,
                'recommend_product'=>$product_id_list,
            ]);
        }

        if($res){
            return $this->echoSuccessJson('更新成功!');
        }else{
            return $this->echoErrorJson('更新失败!');
        }
    }

}