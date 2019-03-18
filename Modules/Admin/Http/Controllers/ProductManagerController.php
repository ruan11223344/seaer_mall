<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Khsing\World\Models\City;
use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use Khsing\World\World;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\AdminLog;
use Modules\Admin\Entities\ProductAudit;
use Modules\Admin\Service\UtilsService;
use Modules\Mall\Entities\BusinessRange;
use Modules\Mall\Entities\BusinessType;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\Products;
use Modules\Mall\Http\Controllers\Shop\ProductsCategoriesController;
use Modules\Mall\Http\Controllers\Shop\ProductsController;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;

class ProductManagerController extends Controller
{
    use EchoJson;

    public static function getProductFormatData($product_orm,$page,$size){
        $product_orm_clone = clone $product_orm;
        $count = $product_orm_clone->count();
        $product_data_list = [];
        $product_orm->offset(($page-1)*$size)->limit($size)->get()->map(function ($v,$k)use(&$product_data_list,$page,$size){
            $price_type = $v->products_price->price_type;
            if($price_type == 'ladder'){
                $min_order_list =[];
                foreach ($v->products_price->ladder_price as $kk=>$vv){
                    $i = [];
                    $i['min_order'] =  $vv['min_order'];
                    $i['order_price'] = $vv['order_price'];
                    $i['unit'] = $vv['unit'];
                    $min_order_list[] = $i;
                }
                $re_order =array_column($min_order_list,'min_order');
                array_multisort($re_order,SORT_ASC, $min_order_list);
                $min_item = array_shift($min_order_list);
                $min_price = $min_item['order_price'];
                $max_price = array_pop($min_order_list)['order_price'];
                $product_price = $v->products_price->currency == 'ksh' ? $min_price .'-'.$max_price : $min_price .'-'.$max_price;
            }elseif($price_type == 'base'){
                $base_price = $v->products_price->base_price[0];
                $product_price = $v->products_price->currency == 'ksh' ? $base_price['min_order_price'] .'-'.$base_price['max_order_price'] : $base_price['min_order_price'] .'-'.$base_price['max_order_price'];
            }

            $price_type = $v->products_price->price_type;
            if ($price_type == 'ladder') {
                $min_order_list = [];
                foreach ($v->products_price->ladder_price as $kk => $vv) {
                    $i                = [];
                    $i['min_order']   = $vv['min_order'];
                    $i['order_price'] = $vv['order_price'];
                    $i['unit']        = $vv['unit'];
                    $min_order_list[] = $i;
                }

                $re_order = array_column($min_order_list, 'min_order');
                array_multisort($re_order, SORT_ASC, $min_order_list);
                $min_item      = array_shift($min_order_list);
                $min_price     = $min_item['order_price'];
                $max_price     = array_pop($min_order_list)['order_price'];
                $product_price = $v->products_price->currency == 'ksh' ? 'KSh ' . $min_price . '-' . $max_price : 'CNY ' . $min_price . '-' . $max_price;
                $product_moq   = "MOQ " . $min_item['min_order'] . ' ' . $min_item['unit'];
            } elseif ($price_type == 'base') {
                $base_price    = $v->products_price->base_price[0];
                $product_price = $v->products_price->currency == 'ksh' ? 'KSh ' . $base_price['min_order_price'] . '-' . $base_price['max_order_price'] : 'CNY ' . $base_price['min_order_price'] . '-' . $base_price['max_order_price'];
                $product_moq   = "MOQ " . $base_price['min_order'] . ' ' . $base_price['unit'];
            }


            $tmp = [];
            $tmp['num'] = $k+1+(($page-1)*$size);
            $tmp['product_id'] = $v->id;
            $tmp['product_moq']  = $product_moq;
            $tmp['product_sku']  = $v->product_sku_no;
            $tmp['product_main_pic_url'] = \Modules\Mall\Http\Controllers\UtilsController::getPathFileUrl($v->product_images[0]['main']);
            $tmp['product_name'] = $v->product_name;
            $tmp['product_origin_id'] = $v->product_origin_id;
            $tmp['product_price'] = $product_price;
            $company = Company::find($v->company_id);
            $tmp['company_name'] = $company != null ? $company->company_name : "";
            $tmp['company_detail_address'] = $company != null ? $company->company_detailed_address : "";
            $tmp['product_status'] = $v->product_status;
            $tmp['product_audit_status'] = $v->product_audit_status;
            if($v->product_status == ProductsController::PRODUCT_STATUS_SALE && $v->product_audit_status == ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS){
                $product_status_str = "出售中";
            }elseif ($v->product_status == ProductsController::PRODUCT_STATUS_SALE && $v->product_audit_status == ProductsController::PRODUCT_AUDIT_STATUS_CHECKING){
                $product_status_str = "等待审核";
            }elseif ($v->product_status == ProductsController::PRODUCT_STATUS_SALE &&  $v->product_audit_status == ProductsController::PRODUCT_AUDIT_STATUS_FAIL){
                $product_status_str = "未通过审核";
            }elseif($v->product_status == ProductsController::PRODUCT_STATUS_WAREHOUSE){
                $product_status_str = "仓库中";
            }
            $tmp['product_status_str'] = $product_status_str;
            $tmp['product_create_time'] = Carbon::parse($v->created_at)->format('Y-m-d H:i:s');
            array_push($product_data_list,$tmp);
        });
        $res_data = [];
        $res_data['data'] = $product_data_list;
        $res_data['size'] = $size;
        $res_data['cur_page'] =$page;
        $res_data['total_page'] = (int)ceil($count/$size);
        $res_data['total_size'] = $count;

        return $res_data;
    }

    public function getProductList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $page = $request->input('page');
        $size = $request->input('size');
        $product_orm = new Products();
        $res_data = self::getProductFormatData($product_orm,$page,$size);
        return $this->echoSuccessJson('获取商品列表数据成功!',$res_data);
    }

    public function getAuditProductList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $page = $request->input('page');
        $size = $request->input('size');
        $product_orm = new Products();
        $res_data = self::getProductFormatData($product_orm->where(
            [
                'product_status'=>ProductsController::PRODUCT_STATUS_SALE,
                'product_audit_status'=>ProductsController::PRODUCT_AUDIT_STATUS_CHECKING,
            ]
        ),$page,$size);
        return $this->echoSuccessJson('获取待审核商品列表数据成功!',$res_data);

    }

    public function getProductInfo(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'product_id'=>'required|exists:products,id,deleted_at,NULL',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $product_id = $request->input('product_id');

        $product = Products::find($product_id);
        $company = Company::find($product->company_id);
        $company_info = [];
        $company_info['company_business_type_id'] = $company->company_business_type_id;
        $company_info['company_business_type_str'] = $company->company_business_type_id != null ? BusinessType::find($company->company_business_type_id)->cn_name : "";

        $company_info['company_name'] = $company->company_name;
        $company_info['company_name_in_china'] = $company->company_name_in_china;
        $company_info['company_country'] = $company->company_country_id != null ? Country::find($company->company_country_id)->name : "";
        $province = Division::find($company->company_province_id);
        $city = City::find($company->company_city_id);
        $company_info['province/city'] =  $province == null ?  null : $province->name .' '.$city->name;
        $company_info['company_detailed_address'] =  $company->company_detailed_address;
        $company_info['company_mobile_phone'] =  $company->company_mobile_phone;
        $company_info['company_website'] =  $company->company_website;
        $business_range = $company->company_business_range_ids;
        $business_range_str = '';
        if($business_range != null){
            $business_range_arr = explode(',',$business_range);
            BusinessRange::whereIn('id',$business_range_arr)->get()->map(function ($v) use(&$business_range_str){
                $business_range_str.= ' '.$v->name.'、';
            });
            $business_range_str = mb_substr($business_range_str,0,mb_strlen($business_range_str)-1);
        }
        $company_info['company_business_range_ids'] = $company->company_business_range_ids;
        $company_info['company_business_range_ids_str'] = $business_range_str;
        $company_info['company_main_products'] =  $company->company_main_products;
        $main_products_str = '';
        if($company->company_main_products != null){
            $main_products_arr = explode(',',$company->company_main_products);
            if(count($main_products_arr) > 1){
                foreach ($main_products_arr as $vs){
                    $main_products_str .= $vs .'、';
                }
                $main_products_str = mb_substr($main_products_str,0,mb_strlen($main_products_str)-1);
            }
        }
        $company_info['company_main_products_str'] =  $main_products_str;
        $company_info['company_profile'] =  $company->company_profile;
        $company_info['company_business_license'] =  $company->company_business_license;
        $company_info['company_business_license_pic_url'] =  $company->company_business_license_pic_url != null ? \Modules\Mall\Http\Controllers\UtilsController::getPathFileUrl($company->company_business_license_pic_url) : "";

        $product_info = [];
        $product_info['product_categories_id'] = $product->product_categories_id;
        $cate_arr = ProductsCategoriesController::getCategoriesParentTreeStr([$product->product_categories_id]);
        $product_info['product_categories_str'] = $product->product_categories_id != null && $cate_arr != null ? array_values($cate_arr)[0]['name'] : "";
        $product_info['product_name'] = $product->product_name;
        $product_info['product_details'] = $product->product_details;
        $product_info['product_sku_no'] = $product->product_sku_no;
        $product_info['product_keywords'] = $product->product_keywords;
        $product_info['product_keywords_str'] = $product->product_keywords != null ? implode('-',$product->product_keywords) : "";
        $product_info['product_images_url'] = [];
        foreach ($product->product_images as $v){
            array_push($product_info['product_images_url'],\Modules\Mall\Http\Controllers\UtilsController::getPathFileUrl(array_values($v)[0]));
        }

        $products_attr = $product->products_attr;
        $products_price = $product->products_price;
        $attr_arr = $products_attr->toArray()['attr_specs'];
        $product_attr_array = array();
        if(count($attr_arr) > 0){
            foreach($attr_arr as $item) {
                $attr = array_values($item)[0];
                $attr_key = array_keys($item)[0];
                array_key_exists($attr_key,$product_attr_array) ? array_push($product_attr_array[$attr_key],$attr) : $product_attr_array[$attr_key][] = $attr;
            }
        }

        $product_info['product_attr_arr'] = array_keys($product_attr_array);
        $product_info['product_attr_str'] = count($product_info['product_attr_arr']) > 1  ? implode('、',$product_info['product_attr_arr']) : "";

        $product_info['product_price_type'] = $products_price->price_type;



        $product_price_array = $products_price->toArray();
        $price_array = [];
        if($product_price_array['price_type'] == 'base'){
            $tmp = '≥'. $product_price_array['base_price'][0]['min_order'] .' Ksh ' .$product_price_array['base_price'][0]['min_order_price'];
            array_push($price_array,$tmp);
        }elseif ($product_price_array['price_type'] == 'ladder'){
            foreach ($product_price_array['ladder_price'] as $v){
                $re_order =array_column($product_price_array['ladder_price'],'min_order');
                array_multisort($re_order,SORT_ASC, $product_price_array['ladder_price']);
                for ($i=0;$i<count($product_price_array['ladder_price']);$i++){
                    $price = $product_price_array['ladder_price'][$i]['order_price'];
                    if($i < count($product_price_array['ladder_price'])-1){
                        $min_order = $product_price_array['ladder_price'][$i]['min_order'];
                        $max_order = ($product_price_array['ladder_price'][$i+1]['min_order']);
                        $tmp = $i == 0 ? '≥'.$min_order.'-'.$max_order.' '. 'Ksh '.$price : '≥'.($min_order+1).'-'.$max_order.' '. 'Ksh '.$price;
                    }else{
                        $tmp = '≥'.''. ($product_price_array['ladder_price'][$i]['min_order']+1).' Ksh '.$price;
                    }
                    if(!in_array($tmp,$price_array)){
                        array_push($price_array,$tmp);
                    }
                }
            }

        }

        $product_info['product_price_str_arr'] = $price_array;

        $res_data = [];
        $res_data['company_info'] = $company_info;
        $res_data['product_info'] = $product_info;
        $product_publish_time_log = AdminLog::where(
            [
                ['type_for_id','=',$product->id],
                ['type','=','audit_product'],
                ['action','=','allow'],
            ]
        )->orderBy('created_at','desc');
        $res_data['product_publish_time'] = $product_publish_time_log->exists() ? $product_publish_time_log->get()->first()->updated_at : "";

        return $this->echoSuccessJson('成功!',$res_data);
    }


    public function auditProduct(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'product_id'=>'required|exists:products,id,deleted_at,NULL',
            'action'=>'required|in:allow,reject',
            'reject_message'=>'nullable',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $product_id = $request->input('product_id');
        $action = $request->input('action');
        $reject_message = $request->input('reject_message',null);

        $product = Products::where('id',$product_id)->get()->first();

        if($product->product_audit_status != ProductsController::PRODUCT_AUDIT_STATUS_CHECKING){
            return $this->echoSuccessJson('不能审核,商品状态不正确!');
        }

        if($product->product_status != ProductsController::PRODUCT_STATUS_SALE){
            return $this->echoSuccessJson('不能审核非预销售商品!');
        }

        if($action == 'reject' && $reject_message == null){
            return $this->echoSuccessJson('如果不通过审核,请键入不通过信息!');
        }

        $admin_id = Auth::id();

        if($action == 'allow'){
            $product->update(
                ['product_audit_status'=>ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS]
            );

            UtilsService::WriteLog('admin','audit_product','approved',$admin_id,$product->id);

            ProductAudit::create(
                [
                    'admin_id'=>$admin_id,
                    'product_id'=>$product->id,
                    'status'=>'success',
                ]
            );

        }elseif ($action == 'reject'){
            if($reject_message == null){
                return $this->echoSuccessJson('不通过审核信息不能为空!');
            }

            $product->update(
                ['product_audit_status'=>ProductsController::PRODUCT_AUDIT_STATUS_FAIL]
            );

            UtilsService::WriteLog('admin','audit_product','not_approved',$admin_id,$product->id);
            ProductAudit::create(
                [
                    'admin_id'=>$admin_id,
                    'product_id'=>$product->id,
                    'message'=>$reject_message,
                    'status'=>'fail',
                ]
            );
        }

        return $this->echoSuccessJson('操作成功!');
    }

    public function productOffShelf(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'product_id'=>'required|exists:products,id,deleted_at,NULL',
            'off_shelf_message'=>'required',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $product_id = $request->input('product_id');

        $product = Products::where('id',$product_id)->get()->first();

        if($product->product_status != ProductsController::PRODUCT_STATUS_SALE || $product->product_audit_status != ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS){
            return $this->echoErrorJson('商品已经是非正常售卖状态!无法下架!');
        }
        $product->product_status = ProductsController::PRODUCT_STATUS_WAREHOUSE;
        $product->product_audit_status = ProductsController::PRODUCT_AUDIT_STATUS_FAIL;
        $product->save();
        $admin_id = Auth::id();
        $off_shelf_message = $request->input('off_shelf_message');
        UtilsService::WriteLog('admin','audit_product','off_shelves',$admin_id,$product->id);
        ProductAudit::create(
            [
                'admin_id'=>$admin_id,
                'product_id'=>$product->id,
                'message'=>$off_shelf_message,
                'status'=>'off_shelf',
            ]
        );

        return $this->echoSuccessJson('操作成功!');
    }

}