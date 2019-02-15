<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers\Shop;

use App\Utils\City;
use App\Utils\EchoJson;
use App\Utils\Oss;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\ProductsAttr;
use Modules\Mall\Entities\ProductsGroup;
use Modules\Mall\Entities\ProductsPrice;
use Modules\Mall\Entities\ProductsProductsGroup;
use Modules\Mall\Entities\UsersExtends;

class ProductsController extends Controller
{
    use EchoJson;

    const PUBLISH_PRODUCT_STATUS_NOT_AUDIT = 0; //不可发布 未审核
    const PUBLISH_PRODUCT_STATUS_NORMAL = 1; //可发布
    const PUBLISH_PRODUCT_STATUS_CHECKING = 2;  //审核中
    const PUBLISH_PRODUCT_STATUS_NOT_APPROVED = 3;  //审核被退回
    const PUBLISH_PRODUCT_STATUS_BANNED = 4;  //被封禁

    const PRODUCT_STATUS_SALE = 1;  //商品在售
    const PRODUCT_STATUS_WAREHOUSE = 0;  //商品在仓库中

    const PRODUCT_AUDIT_STATUS_CHECKING = 0;      //商品审核中
    const PRODUCT_AUDIT_STATUS_NORMAL = 1;  //商品审核中
    const PRODUCT_AUDIT_STATUS_NOT_APPROVED = 2;  //商品审核退回

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

    public static function createProductOriginId(){
        return 1;
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
            'product_attr'=>'required|array', //[{"颜色":"绿色","颜色":"白色","颜色":"黑色"}]
            'product_price'=>'required|array',
            'product_price_type'=>'required|in:base,ladder',
            'product_details'=>'nullable',
            'product_publishing_time'=>'publishing_time',
            'product_categories_id'=>'required|exists:products_categories,id', //分类id
            'product_group_id'=>'nullable|exists:products_group,id',
            'product_status'=>'required|in:0,1'
        ]);



        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }


        $product_name = $request->input('product_name');
        $product_categories_id = $request->input('product_categories_id');
        $product_sku_no = $request->input('product_sku_no');
        $product_keywords = $request->input('product_keywords'); //todo 组装对象格式
        $product_group_id = $request->input('product_group_id');
        $product_attr = $request->input('product_attr');
        $product_images = $request->input('product_images');
        $product_status = $request->input('product_status');
        if($request->input('product_publishing_time') !== null){
            $product_publishing_time = Carbon::parse($request->input('product_publishing_time'))->toDateTimeString();
        }else{
            $product_publishing_time = null;
        }

        try{
            DB::beginTransaction();
            $price_type = $request->input('product_price_type');
            $product_price = $request->input('product_price');

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
                   'product_origin_id'=>self::createProductOriginId(),
                   'product_categories_id'=>$product_categories_id,
                   'product_sku_no'=>$product_sku_no,
                   'product_keywords'=>$product_keywords,
                   'product_images'=>$product_images,
                   'product_status'=>$product_status,
                   'product_publishing_time'=>$product_publishing_time,
                   'product_price_id'=>$product_price_model->id,
                   'product_attr_id'=>$product_attr == null ? null : $product_attr_model->id,
                   'company_id'=>Auth::user()->company->id
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

    }

    public function editProduct(Request $request){

    }




}