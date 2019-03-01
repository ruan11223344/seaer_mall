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
use Khsing\World\Models\City;
use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\Favorites;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\Shop;
use Modules\Mall\Entities\User;
use Modules\Mall\Entities\UsersExtends;
use Modules\Mall\Http\Controllers\Auth\AuthorizationsController;
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
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
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

        return $this->echoSuccessJson('Update the Success!',['img_path'=>$img_path,'img_url'=>$img_url]);
    }

    public static function getShopBannerData($company_id){
        $shop_obj = Shop::where('company_id',$company_id);

        if($shop_obj->exists()){
            $shop_obj  = $shop_obj->get()->first();
            if($shop_obj->banner_url == null){
                return [];
            }
            return ['banner_path'=>$shop_obj->banner_url,'banner_url'=>UtilsController::getPathFileUrl($shop_obj->banner_url)];
        }else{
            return [];
        }
    }

    public function getShopBanner(){
        $company_id = Auth::user()->company->id;
        $data = self::getShopBannerData($company_id);
        if($data == null){
            return $this->echoErrorJson('错误!没有设置过banner!');
        }else{
            return $this->echoSuccessJson('Set the bannaer Success!',$data);
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

        return $this->echoSuccessJson('Delete banner Success!');
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
                        $validator->setCustomMessages(['slide_list_check' => 'Missing corresponding object!']);
                        return false;
                    }

                    if(stripos($v['url_path'],$path) === false){
                        $validator->setCustomMessages(['slide_list_check' => 'image path error!']);
                        return false;
                    }

                    if($v['url_jump'] != null){
                        if(stripos($v['url_jump'],$site_domain) === false){
                            $validator->setCustomMessages(['slide_list_check' => 'Cannot set up except afriby.com link!']);
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
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
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

        return $this->echoSuccessJson('Set the slide picture Success!');
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
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $img = UtilsController::uploadFilesByBase64([$request->input('slide_img_base64')]);
        return $this->echoSuccessJson('Upload Success!',['img_path'=>$img[0]['path'],'img_url'=>$img[0]['file_url']]);
    }

    public static function getSlidesData($company_id){
        $shop_obj = Shop::where('company_id',$company_id);
        if($shop_obj->exists()){
            $shop_obj = $shop_obj->get()->first();
            if($shop_obj->slides_url_list == null){
                return [];
            }else{
                $res_data = $shop_obj->slides_url_list;
                foreach ($res_data as $k=>$v){
                    $res_data[$k]['url'] = UtilsController::getPathFileUrl($v['url_path']);
                }
                return $res_data;
            }
        }else{
            return [];
        }
    }

    public function getSlidesList(){
        $company_id = Auth::user()->company->id;
        $res = self::getSlidesData($company_id);
        if($res == null){
            return $this->echoErrorJson('Error!No round robin has been set！');
        }else{
            return $this->echoSuccessJson('Get the round robin map Success!',$res);
        }
    }

    public static function getRecommendProductData($company_id){
        $shop = Shop::where('company_id',$company_id);
        $res = [];
        if($shop->exists()){
            $shop_obj =  $shop->get()->first();
            if($shop_obj->recommend_product != null){
                $product_arr = $shop_obj->recommend_product;
                $product_obj= Products::where(
                    [
                        ['company_id','=',$company_id],
                        ['product_status','=',ProductsController::PRODUCT_STATUS_SALE],
                        ['product_audit_status','=',ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS],
                    ]
                )->whereIn('id',$product_arr);
                if($product_obj->count() > 0){
                    $res = ProductsController::getProductFormatInfo($product_obj);
                }
            }
        }

        return $res;
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
               $product_obj= Products::where(
                   [
                       ['company_id','=',$company_id],
                       ['product_status','=',ProductsController::PRODUCT_STATUS_SALE],
                       ['product_audit_status','=',ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS],
                   ]
               )->whereIn('id',$product_arr);
               if($product_obj->count() > 0){
                   $res = ProductsController::getProductFormatInfo($product_obj);
                   $product_id_list = $product_obj->get()->pluck('id')->toArray();
               }
           }
        }
        return $this->echoSuccessJson('Get the product recommendation list Success!',['product_info_list'=>$res,'recommend_product_id_list'=>$product_id_list]);
    }

    public function searchRecommendProduct(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'product_name'=>'nullable',
            'sku'=>'nullable',
            'product_origin_id'=>'nullable',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
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
            return $this->echoErrorJson('No results were found!');
        }

        return $this->echoSuccessJson('Get the search result Success!',['search_res_product_info_list'=>$res]);
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
                    $validator->setCustomMessages(['product_id_list_check' => 'Product_id does not belong to your account , id:'.$v]);
                    return false;
                }

                if($p_item->product_status != 1 || $p_item->product_audit_status !=1){
                    $validator->setCustomMessages(['product_id_list_check' => 'product_id is not on shelves, id:'.$v]);
                    return false;
                }

            }
            return true;
        });

        $validator = Validator::make($data, [
            'product_id_list'=>'required|array|product_id_list_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
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
            return $this->echoSuccessJson('Update the Success!');
        }else{
            return $this->echoErrorJson('Update failed!');
        }
    }

    public function shopSearch(Request $request){
        $keywords = $request->input('keywords');
        $company_obj = Company::where('company_name','like','%'.$keywords.'%')->orWhere(
            'company_name_in_china','like','%'.$keywords.'%'
        )->get();

        if($company_obj->isEmpty()){
            return $this->echoErrorJson('没有搜索到店铺!');
        }else{
            $company_arr = $company_obj->toArray();
            foreach ($company_arr as $k=>$v){
                unset($company_arr[$k]['company_business_license']);
                unset($company_arr[$k]['company_business_license_pic_url']);
                $company_arr[$k]['company_country_name'] = $v['company_country_id'] == null ? null : Country::find($v['company_country_id'])->name;
                $main_products = $v['company_main_products'];
                $main_products_str = '';
                if($main_products != null){
                    $main_products_arr = explode(',',$main_products);
                    if(count($main_products_arr > 1)){
                        foreach ($main_products_arr as $vs){
                            $main_products_str .= $vs .'、';
                        }
                        $main_products_str = mb_substr($main_products_str,0,mb_strlen($main_products_str)-1);
                    }
                }
                $company_arr[$k]['main_products_str']  = $main_products_str;
                if($v['company_province_id'] != null){
                    $province = Division::find($v['company_province_id']);
                }else{
                    $province = null;
                }

                if($v['company_city_id'] != null){
                    $city = City::find($v['company_city_id']);
                }else{
                    $city = null;
                }
                $company_arr[$k]['location'] = $province != null ? $province->name : '' . $city != null ? $city->name : '';
                $company_arr[$k]['telephone'] = $v['company_mobile_phone'];
            }

            return $this->echoSuccessJson('Search store Success!',$company_arr);
        }
    }

    public function getCompanyDetail(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'company_id'=>'required|exists:company,id',
            'user_id'=>'nullable|exists:users,id'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $company_id = $request->input('company_id');
        $data =AuthorizationsController::getCompanyInfoData($company_id);
        $user_obj = User::find($request->input('user_id'));
        $data['is_favorites_company'] = $user_obj == null ? false : Favorites::where(
            [
                ['company_id','=',$user_obj->company->id],
                ['type','=','company'],
                ['product_or_company_id','=',$company_id],
            ])->exists() ? true : false;
        return $this->echoSuccessJson('Obtain company information about Success!',$data);
    }

}