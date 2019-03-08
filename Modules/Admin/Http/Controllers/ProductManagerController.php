<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Mall\Entities\BusinessType;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\Products;
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

            $tmp = [];
            $tmp['num'] = $k+1+(($page-1)*$size);
            $tmp['product_id'] = $v->id;
            $tmp['product_name'] = $v->product_name;
            $tmp['product_origin_id'] = $v->product_origin_id;
            $tmp['product_price'] = $product_price;
            $company = Company::find($v->company_id);
            $tmp['company_name'] = $company != null ? $company->company_name : "";
            $tmp['company_detail_address'] = $company != null ? $company->company_detailed_address : "";
            $tmp['product_status'] = $v->product_status; //todo
            $tmp['product_audit_status'] = $v->product_audit_status; //todo
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
            'product_id'=>'required|exists:product,id,deleted_at,NULL',
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

        $business_range = $company->company_business_range_ids;
        $business_range_str = '';
        if($business_range != null){
            $business_range_arr = explode(',',$business_range);
            BusinessRange::whereIn('id',$business_range_arr)->get()->map(function ($v,$k) use(&$business_range_str){
                $business_range_str.= ' '.$v->name.'、';
            });
            $business_range_str = mb_substr($business_range_str,0,mb_strlen($business_range_str)-1);
        }
        $company_info['company_business_range_ids'] = $company->company_business_range_ids;
        $company_info['company_business_range_ids_str'] = $business_range_str;




        $res_data = [];
        $res_data['company_info'] = $company_info;
        $res_data['business_info'] = 1;
        $res_data['product_price'] = 1;
        $res_data['product_details'] = 1;
        $res_data['publish_time'] = 1;
    }

}