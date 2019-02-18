<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers\Shop;

use App\Utils\EchoJson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\ProductsAttr;
use Modules\Mall\Entities\ProductsPrice;
use Modules\Mall\Entities\ProductsProductsGroup;
use Modules\Mall\Entities\UsersExtends;
use Modules\Mall\Http\Controllers\UtilsController;
use Webpatser\Uuid\Uuid;


class ProductsController extends Controller
{
    use EchoJson;

    const PUBLISH_PRODUCT_STATUS_NOT_AUDIT = 0; //不可发布 未审核
    const PUBLISH_PRODUCT_STATUS_NORMAL = 1; //可发布
    const PUBLISH_PRODUCT_STATUS_CHECKING = 2;  //审核中
    const PUBLISH_PRODUCT_STATUS_NOT_APPROVED = 3;  //审核被退回
    const PUBLISH_PRODUCT_STATUS_BANNED = 4;  //被封禁

    const PRODUCT_STATUS_SALE = 1;  //商品正常售卖中
    const PRODUCT_STATUS_WAREHOUSE = 2;  //在仓库中

    const PRODUCT_AUDIT_STATUS_CHECKING = 0; //商品审核中
    const PRODUCT_AUDIT_STATUS_SUCCESS = 1;  //商品审核成功
    const PRODUCT_AUDIT_STATUS_FAIL = 2;  //商品审核未通过

    /**
     * 获取商品发布的权限
     *
     * @return json
     */
    public function checkPublishProductPermissions(){ //检测是否有商品发布权
        $pub_status_msg = self::getPublishProductPermissions();
        return $this->echoSuccessJson('获取商品发布权限成功!',['publish_product_permission'=>$pub_status_msg[0],'publish_product_permission_message'=>$pub_status_msg[1]]);
    }

    /**
     * 获取商品发布的权限
     *
     * @return array
     */
    static function getPublishProductPermissions(){
        $pub_status = Auth::user()->usersExtends->publish_product_status;
        $message = '';
        switch ($pub_status){
            case self::PUBLISH_PRODUCT_STATUS_NOT_AUDIT:
                $message = '从未提交审核店铺资料,不能发布商品!';
                $status = false;
                break;
            case self::PUBLISH_PRODUCT_STATUS_NORMAL:
                $message = '店铺资料通过审核可以发布商品!';
                $status = true;
                break;
            case self::PUBLISH_PRODUCT_STATUS_CHECKING:
                $message = '店铺资料正在审核中,暂时无法发布商品!';
                $status = false;
                break;
            case self::PUBLISH_PRODUCT_STATUS_NOT_APPROVED:
                $message = '店铺资料审核被退回,请重新提交审核,暂时无法发布商品!';
                $status = false;
                break;
            case self::PUBLISH_PRODUCT_STATUS_BANNED:
                $message = '店铺资料被封禁,无法发布商品!';
                $status = false;
                break;
        }

        return [$status,$message];
    }

    public static function createProductOriginId($user_obj){
        if($user_obj->usersExtends->account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA){
            $region = 'CN';
        }elseif ($user_obj->usersExtends->account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_KENYA){
            $region = 'KE';
        }
        $af_id_end = substr($user_obj->usersExtends->af_id,7,10);
        $pd_str = 'PD_'.$region.'_'.$af_id_end.'_';
        $pd_str .= substr(Uuid::generate(),0,8);
        return $pd_str;
    }

    public function publishProduct(Request $request){

        $data = $request->all();

        Validator::extend('publishing_time', function($attribute, $value, $parameters,$validator)
        {
            if($value == null){
                return true;
            }else{
                if(Carbon::parse($value)->timestamp < time()){
                    $validator->setCustomMessages(['publishing_time' => 'just can select future time!']);
                    return false;
                }else{
                    return true;
                }
            }


        });

        $validator = Validator::make($data,[
            'product_name'=>'required',
            'product_sku_no'=>'required',
            'product_keywords'=>'required|array',
            'product_images'=>'required|array',
            'product_attr'=>'required|array',
            'product_price'=>'required|array',
            'product_price_type'=>'required|in:base,ladder',
            'product_details'=>'nullable',
            'product_publishing_time'=>'publishing_time',
            'product_categories_id'=>'required|exists:products_categories,id',
            'product_group_id'=>'nullable|exists:products_group,id',
            'product_put_warehouse'=>'required|boolean'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $pub_status = self::getPublishProductPermissions();

        if($pub_status[0] == false){
            return $this->echoErrorJson('不能发布商品! 详细信息: '.$pub_status[1]);
        }



        $product_name = $request->input('product_name');
        $product_categories_id = $request->input('product_categories_id');
        $product_sku_no = $request->input('product_sku_no');
        $product_keywords = $request->input('product_keywords');
        $product_group_id = $request->input('product_group_id');
        $product_attr = $request->input('product_attr');
        $product_images = $request->input('product_images');
        if($request->input('product_publishing_time') !== null){
            $product_publishing_time = Carbon::parse($request->input('product_publishing_time'))->toDateTimeString();
        }else{
            $product_publishing_time = null;
        }

        try{
            if(Products::where([
                ['product_name','=',$product_name],
                ['company_id','=',Auth::user()->company->id],
            ])->exists()){
                return $this->echoErrorJson('错误!仓库或者在售中存在相同名称的商品!无法发布!');
            }


            DB::beginTransaction();
            $price_type = $request->input('product_price_type');
            $product_price = $request->input('product_price');

            if($price_type == 'ladder'){
                foreach ($product_price as $v){
                    foreach ($v as $vv){
                        if(!(isset($vv['unit']) && isset($vv['min_order']) && isset($vv['order_price']))){
                            return $this->echoErrorJson('存在错误的阶梯价格式!');
                        }
                    }

                }
            }elseif ($price_type == 'base'){
                foreach ($product_price as $v){
                    if(!(isset($v['unit']) && isset($v['min_order']) && isset($v['max_order_price']) && isset($v['min_order_price']))){
                        return $this->echoErrorJson('基本价价格格式错误!缺少对象!');
                    }
                }
            }

            $product_price_model = ProductsPrice::create(
                [
                    'price_type'=>$price_type,
                    'base_price'=>$price_type == 'base' ? $product_price : null,
                    'ladder_price'=>$price_type == 'ladder' ? $product_price : null,
                ]
            );

            if($product_attr !== null){
                $product_attr_model = ProductsAttr::create(
                    [
                        'attr_specs'=>$product_attr
                    ]
                );
            }


           $product_model = Products::create(
               [
                   'product_name'=>$product_name,
                   'product_origin_id'=>self::createProductOriginId(Auth::user()),
                   'product_categories_id'=>$product_categories_id,
                   'product_sku_no'=>$product_sku_no,
                   'product_keywords'=>$product_keywords,
                   'product_images'=>$product_images,
                   'product_status'=>$request->input('product_put_warehouse') == true ? self::PRODUCT_STATUS_WAREHOUSE : self::PRODUCT_STATUS_SALE,
                   'product_publishing_time'=>$product_publishing_time,
                   'product_price_id'=>$product_price_model->id,
                   'product_attr_id'=>$product_attr == null ? null : $product_attr_model->id,
                   'company_id'=>Auth::user()->company->id,
                   'product_details'=>$request->input('product_details'),
                   'product_audit_status'=>self::PRODUCT_AUDIT_STATUS_CHECKING
               ]
            );
           //商品分组
           if($product_group_id !== null){
               ProductsProductsGroup::create(
                   [
                       'product_id'=>$product_model->id,
                       'product_group_id'=>$product_group_id
                   ]
               );
           }
           DB::commit();
           return $this->echoSuccessJson('创建商品成功!');
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('创建商品失败! 错误信息: '.$e->getMessage());
        }
    }

    public function uploadProductImg(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'product_img'=>'image|max:1024|required',
            'where'=>'required|in:main,1,2,3,4'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $img = UtilsController::uploadFile($data['product_img'],UtilsController::getUserProductDirectory(),true);
        return $this->echoSuccessJson('上传成功!',['img_path'=>$img,'img_url'=>UtilsController::getPathFileUrl(array_values($img)[0]),'where'=>$request->input('where')]);
    }

    public function editProduct(Request $request){

    }

    public function deleteProduct(Request $request){

    }

    public function getProductList(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'status'=>'required|in:selling,check_pending,unapprove,in_the_warehouse',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $status = $request->input('status');
        $products_orm = Products::where('company_id',Auth::user()->company->id);


        switch ($status){
            case 'selling':
                $products_orm->where('product_status',self::PRODUCT_STATUS_SALE)->where('product_audit_status',self::PRODUCT_AUDIT_STATUS_SUCCESS);
                break;
            case 'check_pending':
                $products_orm->where('product_audit_status',self::PRODUCT_AUDIT_STATUS_CHECKING);
                break;
            case 'unapprove':
                $products_orm->where('product_audit_status',self::PRODUCT_AUDIT_STATUS_FAIL);
                break;
            case 'in_the_warehouse':
                $products_orm->where('product_status',self::PRODUCT_STATUS_WAREHOUSE);
                break;
        }

        if($products_orm->count() == 0){
            return $this->echoErrorJson('没有任何记录');
        }

        $res = [];

        $products_orm->get()->map(function ($v,$k) use (&$res){

            $price_type = $v->products_price->price_type;
            if($price_type == 'ladder'){
                $min_order_list =[];
                foreach ($v->products_price->ladder_price as $kk=>$vv){
                    $i = [];
                    $i['min_order'] =  $vv[0]['min_order'];
                    $i['order_price'] = $vv[0]['order_price'];
                    $i['unit'] = $vv[0]['unit'];
                    $min_order_list[] = $i;
                }

                $re_order =array_column($min_order_list,'min_order');
                array_multisort($re_order,SORT_ASC, $min_order_list);
                $min_item = array_shift($min_order_list);
                $min_price = $min_item['order_price'];
                $max_price = array_pop($min_order_list)['order_price'];
                $product_price = $v->products_price->currency == 'ksh' ? 'KSh ' .$min_price .'-'.$max_price : 'CNY ' .$min_price .'-'.$max_price;
                $product_moq = "MOQ ".$min_item['min_order'].' '.$min_item['unit'];
            }elseif($price_type == 'base'){
                $base_price = $v->products_price->base_price;
                $product_price = $v->products_price->currency == 'ksh' ? 'KSh ' .$base_price[0]['min_order_price'] .'-'.$base_price[0]['max_order_price'] : 'CNY ' .$base_price[0]['min_order_price'] .'-'.$base_price[0]['max_order_price'];
                $product_moq = "MOQ ".$base_price[0]['min_order'].' '.$base_price[0]['unit'];
            }

            $item = [
                'product_id'=>$v->id,
                'product_name'=>$v->product_name,
                'product_sku'=>$v->product_sku_no,
                'product_price'=>$product_price,
                'price_type'=>$price_type,
                'product_moq'=>$product_moq,
                'publish_time'=>$v->updated_at != null ? Carbon::parse($v->updated_at)->toDateTimeString() : Carbon::parse($v->created_at)->toDateTimeString(),
                'product_main_pic_url'=>UtilsController::getPathFileUrl($v->product_images[0]['main']),
                'product_origin_id'=>$v->product_origin_id,
            ];
            array_push($res,$item);
        });

        return $this->echoSuccessJson('获取商品列表成功!',$res);



    }

}