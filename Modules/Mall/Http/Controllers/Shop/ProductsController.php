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
use Modules\Mall\Entities\Favorites;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\ProductsAttr;
use Modules\Mall\Entities\ProductsCategories;
use Modules\Mall\Entities\ProductsGroup;
use Modules\Mall\Entities\ProductsPrice;
use Modules\Mall\Entities\ProductsProductsGroup;
use Modules\Mall\Entities\User;
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
                $message = '店铺被封禁,无法发布商品!';
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
        $put_warehouse = $request->input('product_put_warehouse');

        if($request->input('product_publishing_time') !== null){
            $carbon_obj = Carbon::parse($request->input('product_publishing_time'));
            $product_publishing_time = $carbon_obj->toDateTimeString();
        }else{
            $product_publishing_time = null;
        }

        if(($pub_status[0] == false && $put_warehouse == false) ||  ($pub_status[0] == false && $product_publishing_time !== null)){
            return $this->echoErrorJson('不能发布商品! 详细信息: '.$pub_status[1]);
        }


        $product_name = $request->input('product_name');
        $product_categories_id = $request->input('product_categories_id');
        $product_sku_no = $request->input('product_sku_no');
        $product_keywords = $request->input('product_keywords');
        $product_group_id = $request->input('product_group_id');
        $product_attr = $request->input('product_attr');
        $product_images = $request->input('product_images');


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
                        if(!(isset($v['unit']) && isset($v['min_order']) && isset($v['order_price']))){
                            return $this->echoErrorJson('存在错误的阶梯价格式!');
                    }
                }
            }elseif ($price_type == 'base'){
                foreach ($product_price as $v){
                    if(!(isset($v['unit']) && isset($v['min_order']) && isset($v['max_order_price']) && isset($v['min_order_price']))){
                        return $this->echoErrorJson('基本价价格格式错误!缺少对象!');
                    }

                    if($v['max_order_price'] < $v['min_order_price']){
                        return $this->echoErrorJson('基本价最大价格不能小于最小价格!');
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
                   'product_categories_id'=>$product_categories_id,
                   'product_sku_no'=>$product_sku_no,
                   'product_keywords'=>$product_keywords,
                   'product_images'=>$product_images,
                   'product_status'=>$put_warehouse == true ? self::PRODUCT_STATUS_WAREHOUSE : self::PRODUCT_STATUS_SALE,
                   'product_publishing_time'=>$product_publishing_time,
                   'product_price_id'=>$product_price_model->id,
                   'product_attr_id'=>$product_attr == null ? null : $product_attr_model->id,
                   'product_details'=>$request->input('product_details',null),
                   'product_audit_status'=>self::PRODUCT_AUDIT_STATUS_CHECKING,
                   'company_id'=>Auth::user()->company->id,
                   'product_origin_id'=>self::createProductOriginId(Auth::user())
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
        return $this->echoSuccessJson('上传成功!',['img_path'=>$img['path'],'img_url'=>$img['url'],'where'=>$request->input('where')]);
    }

    public function editProduct(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'product_id'=>'required|exists:products,id',
            'product_name'=>'nullable',
            'product_sku_no'=>'nullable',
            'product_keywords'=>'nullable|array',
            'product_images'=>'nullable|array',
            'product_attr'=>'nullable|array',
            'product_price'=>'nullable|array',
            'product_price_type'=>'nullable|in:base,ladder',
            'product_details'=>'nullable',
            'product_publishing_time'=>'nullable',
            'product_categories_id'=>'nullable|exists:products_categories,id',
            'product_group_id'=>'nullable|exists:products_group,id',
            'product_put_warehouse'=>'nullable|boolean'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $product_obj = Products::find($request->input('product_id'));

        if($product_obj == null){
            return $this->echoErrorJson('错误!该商品不存在!');
        }

        if($product_obj->company_id != Auth::user()->company->id){
            return $this->echoErrorJson('只能编辑自己的商品!');
        }

        $price_type = $request->input('product_price_type',null);
        $product_price = $request->input('product_price',null);
        $product_attr = $request->input('product_attr',null);
        $product_name = $request->input('product_name',null);
        $product_categories_id = $request->input('product_categories_id',null);
        $product_sku_no = $request->input('product_sku_no',null);
        $product_keywords = $request->input('product_keywords',null);
        $product_group_id = $request->input('product_group_id',null);
        $product_images = $request->input('product_images',null);
        $put_warehouse = $request->input('product_put_warehouse',null);
        $product_publishing_time = $request->input('product_publishing_time',null);
        $product_details = $request->input('product_details',null);


        try{
            DB::beginTransaction();

            if($product_publishing_time == null){
                DB::table('products')->where('id',$product_obj->id)->update([
                    'product_publishing_time'=>null
                ]);
            }

            if($product_name !== null){
                if(Products::where(
                    [
                        ['company_id','=',Auth::user()->company->id],
                        ['product_name','=',$product_name],
                        ['id','!=',$product_obj->id],
                    ]
                )->exists()){
                    return $this->echoErrorJson('错误!存在相同名称的商品,不能使用该商品名!');
                }
            }

            //更新价格
            if($price_type !== null && $product_price !== null){
                if($price_type == 'ladder'){
                    foreach ($product_price as $v){
                        if(!(isset($v['unit']) && isset($v['min_order']) && isset($v['order_price']))){
                            return $this->echoErrorJson('存在错误的阶梯价格式!');
                        }
                    }
                }elseif($price_type == 'base'){
                    foreach ($product_price as $v){
                        if(!(isset($v['unit']) && isset($v['min_order']) && isset($v['max_order_price']) && isset($v['min_order_price']))){
                            return $this->echoErrorJson('基本价价格格式错误!缺少对象!');
                        }
                    }
                }

                $product_obj->products_price->update(
                    [
                        'price_type'=>$price_type,
                        'base_price'=>$price_type == 'base' ? $product_price : null,
                        'ladder_price'=>$price_type == 'ladder' ? $product_price : null,
                    ]
                );
            }

        //更新属性
        if($product_attr !== null){
            $product_obj->products_attr->update(
                [
                    'attr_specs'=>$product_attr
                ]
            );
        }

        if($product_publishing_time !== null){
            $carbon_obj = Carbon::parse($request->input('product_publishing_time'));
            if($carbon_obj->timestamp+1200 < time()){
                return $this->echoErrorJson('定时发布时间只能是在将来的时间!');
            }
            $product_publishing_time = $carbon_obj->toDateTimeString();
        }

        $update_data = [
            'product_name'=>$product_name,
            'product_categories_id'=>$product_categories_id,
            'product_sku_no'=>$product_sku_no,
            'product_keywords'=>$product_keywords,
            'product_images'=>$product_images,
            'product_status'=>$put_warehouse == null ? null : $put_warehouse == true ? self::PRODUCT_STATUS_WAREHOUSE : self::PRODUCT_STATUS_SALE,
            'product_publishing_time'=>$product_publishing_time,
            'product_details'=>$product_details,
            'product_audit_status'=>self::PRODUCT_AUDIT_STATUS_CHECKING
        ];

        foreach ($update_data as $k=>$v){
            if($v == null){
                unset($update_data[$k]);
            }
        }

        //更新商品
        $product_obj->update($update_data);

        //更新分组
        if($product_group_id !== null){
            $p_group = ProductsGroup::find($product_group_id);
            if($p_group == null){
                return $this->echoErrorJson('错误,商品分组id不存在!');
            }else{
                if($p_group->user_id != Auth::id()){
                    return $this->echoErrorJson('错误,该商品分组不属于该用户!');
                }else{
                    if(!ProductsProductsGroup::where('product_id',$product_obj->id)->exists()){
                        ProductsProductsGroup::create(
                            [
                                'product_id'=>$product_obj->id,
                                'product_group_id'=>$product_group_id
                            ]
                        );
                    }else{
                        $product_obj->products_products_group->update(
                            ['product_group_id'=>$product_group_id]
                        );
                    }
                }
            }
        }

        DB::commit();

        }catch (Exception $e){
            DB::rollBack();
            return $this->echoErrorJson('数据库错误 详情:'.$e->getMessage());
        }

        return $this->echoSuccessJson('编辑更新商品成功!');
    }

    public function deleteProduct(Request $request){
        $data = $request->all();

        Validator::extend('product_id_list', function($attribute, $value, $parameters,$validator)
        {
            if(is_array($value)){
                foreach ($value as $v){
                    if(Products::find($v) == null){
                        $validator->setCustomMessages(['product_id_list' => "dot't exits !id:".$v]);
                        return false;
                    }
                }
            }else{
                $validator->setCustomMessages(['product_id_list' => 'product_id_list must be a array!']);
                return false;
            }
            return true;
        });

        $validator = Validator::make($data, [
            'product_id_list'=>'required|product_id_list',
            'status'=>'required|in:selling,check_pending,unapprove,in_the_warehouse',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $product_id_list = $request->input('product_id_list');



        $product_obj = Products::whereIn('id',$product_id_list)->get();

        foreach ($product_obj as $v){
            if($v == null){
                return $this->echoErrorJson('错误!该商品不存在!');
            }

            if($v->company_id != Auth::user()->company->id){
                return $this->echoErrorJson('只能删除自己的商品!');
            }

            $v->products_attr->delete();
            $v->products_price->delete();
            $v->delete();
        }

        $status = $request->input('status');

        $res = self::getStatusProductData($status);

        return $this->echoSuccessJson('删除商品成功!',['data_list'=>$res,'total'=>count($res)]);

    }

    public static function getStatusProductData($status_str){
        $products_orm = Products::where('company_id',Auth::user()->company->id);
        switch ($status_str){
            case 'selling':
                $products_orm->where('product_status',self::PRODUCT_STATUS_SALE)->where('product_audit_status',self::PRODUCT_AUDIT_STATUS_SUCCESS);
                break;
            case 'check_pending':
                $products_orm->where('product_audit_status',self::PRODUCT_AUDIT_STATUS_CHECKING)->where('product_status',self::PRODUCT_STATUS_SALE);
                break;
            case 'unapprove':
                $products_orm->where('product_audit_status',self::PRODUCT_AUDIT_STATUS_FAIL);
                break;
            case 'in_the_warehouse':
                $products_orm->where('product_status',self::PRODUCT_STATUS_WAREHOUSE);
                break;
        }

        if($products_orm->count() == 0){
            return [];
        }

        $res = self::getProductFormatInfo($products_orm);

        return $res;
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

        $res = self::getStatusProductData($status);

        return $this->echoSuccessJson('获取商品列表成功!',['data_list'=>$res,'total'=>count($res)]);
    }

    public function getProductDetail(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'product_id'=>'required|exists:products,id',
            'user_id'=>'nullable|exists:users,id'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $product_id = $request->input('product_id');

        $product_obj = Products::find($product_id);

        if($product_obj == null){
            return $this->echoErrorJson('该商品不存在!');
        }

        $products_attr = $product_obj->products_attr;
        $products_price = $product_obj->products_price;
        $attr_arr = $products_attr->toArray()['attr_specs'];
        $product_attr_array = array();


        $product_price_array = $products_price->toArray();
        $price_array = [];
        if($product_price_array['price_type'] == 'base'){
            $tmp = [];
            $tmp['unit'] = $product_price_array['base_price'][0]['unit'];
            $tmp['moq'] = 'MOQ: '.$product_price_array['base_price'][0]['min_order'].' '.$tmp['unit'];
            $tmp['price'] = $product_price_array['base_price'][0]['min_order_price'];
            array_push($price_array,$tmp);
        }elseif ($product_price_array['price_type'] == 'ladder'){
            foreach ($product_price_array['ladder_price'] as $v){
                $re_order =array_column($product_price_array['ladder_price'],'min_order');
                array_multisort($re_order,SORT_ASC, $product_price_array['ladder_price']);
                for ($i=0;$i<count($product_price_array['ladder_price']);$i++){
                        $tmp = [];
                        if($i < count($product_price_array['ladder_price'])-1){
                            $min_order = $product_price_array['ladder_price'][$i]['min_order'];
                            $max_order = ($product_price_array['ladder_price'][$i+1]['min_order']);
                            $tmp['moq'] = $i == 0 ? 'MOQ: '.$min_order.'-'.$max_order.' '. $product_price_array['ladder_price'][$i]['unit'] : 'MOQ: '.($min_order+1).'-'.$max_order.' '. $product_price_array['ladder_price'][$i]['unit'];
                            $tmp['unit'] = $v['unit'];
                            $tmp['price'] = $product_price_array['ladder_price'][$i]['order_price'];
                        }else{
                            $tmp['moq'] = 'MOQ: ≥'.''. ($product_price_array['ladder_price'][$i]['min_order']+1);
                            $tmp['unit'] = $v['unit'];
                            $tmp['price'] = $product_price_array['ladder_price'][$i]['order_price'];
                        }
                        if(!in_array($tmp,$price_array)){
                            array_push($price_array,$tmp);
                        }
                }
            }

        }


        if(count($attr_arr) > 0){
            foreach($attr_arr as $item) {
                $attr = array_values($item)[0];
                $attr_key = array_keys($item)[0];
                array_key_exists($attr_key,$product_attr_array) ? array_push($product_attr_array[$attr_key],$attr) : $product_attr_array[$attr_key] = [];
            }
        }

        $product_info = $product_obj->toArray();
        $product_info['status_str'] = '';
        $product_info['price_array'] = $price_array;
        if($product_info['product_status'] == self::PRODUCT_STATUS_SALE){
            $product_info['status_str'] = 'Release';
        }

        if($product_info['product_status'] == self::PRODUCT_STATUS_WAREHOUSE){
            $product_info['status_str'] = 'Put';
        }

        if($product_info['product_publishing_time'] != null){
            $product_info['status_str'] = 'Time';
        }
        $product_group = ProductsProductsGroup::where('product_id',$product_id)->get()->first();
        $product_info['product_group_id'] = $product_group != null ? $product_group->product_group_id : null;
        $product_info['product_group_name'] = $product_group != null ? ProductsGroup::find($product_group->product_group_id)->group_name : null;
        $product_group_p_id =  $product_group == null ? null:ProductsGroup::find($product_group->product_group_id)->parent_id;
        $product_info['product_group_parent_id'] = $product_group == null ? null : $product_group_p_id == 0 ? null : $product_group_p_id;
        $product_info['product_group_parent_name'] = $product_group_p_id == null ? null : ProductsGroup::find($product_group->product_group_id)->group_name;
        $product_info['product_images_url'] = [];
        foreach ($product_info['product_images'] as $v){
            array_push($product_info['product_images_url'],UtilsController::getPathFileUrl(array_values($v)[0]));
        }

        $product_info['product_group_parent_child_id'] = [];

        if($product_info['product_group_parent_id'] != null){
            array_push($product_info['product_group_parent_child_id'],$product_info['product_group_parent_id']);
        }

        if($product_info['product_group_id'] != null){
            array_push($product_info['product_group_parent_child_id'],$product_info['product_group_id']);
        }

        $product_format_info = self::getProductFormatInfo(Products::where('id',$product_id));

        $user_id = $request->input('user_id',null);

        if($user_id == null){
            $is_favorites_shop = false;
            $is_favorites_product = false;
        }else{
            $is_favorites_product = Favorites::where(
                [
                    ['company_id','=',User::find($user_id)->company->id],
                    ['type','=','product'],
                    ['product_or_company_id','=',$product_id],
                ]
            )->exists();
            $is_favorites_shop = Favorites::where(
                [
                    ['company_id','=',User::find($user_id)->company->id],
                    ['type','=','company'],
                    ['product_or_company_id','=',$product_info['company_id']],
                ]
            )->exists();
        }

        $res = ['product_info'=>$product_info,'product_attr'=>$products_attr->toArray(),'product_price'=>$products_price->toArray(),'product_attr_array'=>$product_attr_array,'product_format_info'=>$product_format_info,'is_favorites_shop'=>$is_favorites_shop,'is_favorites_product'=>$is_favorites_product];

        return $this->echoSuccessJson('获取商品详情成功!',$res);
    }

    public static function getProductFormatInfo($products_orm){
        $res = [];
        $products_orm->get()->map(function ($v,$k) use (&$res){

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
                $product_price = $v->products_price->currency == 'ksh' ? 'KSh ' .$min_price .'-'.$max_price : 'CNY ' .$min_price .'-'.$max_price;
                $product_moq = "MOQ ".$min_item['min_order'].' '.$min_item['unit'];
            }elseif($price_type == 'base'){
                $base_price = $v->products_price->base_price[0];
                $product_price = $v->products_price->currency == 'ksh' ? 'KSh ' .$base_price['min_order_price'] .'-'.$base_price['max_order_price'] : 'CNY ' .$base_price['min_order_price'] .'-'.$base_price['max_order_price'];
                $product_moq = "MOQ ".$base_price['min_order'].' '.$base_price['unit'];
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
                'company_id'=>$v->company_id,
            ];
            array_push($res,$item);
        });

        return $res;
    }

    public function changeProductsWarehouse(Request $request){
        $data = $request->all();

        Validator::extend('check_product_id_list', function($attribute, $value, $parameters,$validator)
        {
            if(is_array($value)){
                foreach ($value as $v){
                    if(Products::find($v) == null){
                        $validator->setCustomMessages(['check_product_id_list' => "dot't exits !id:".$v]);
                        return false;
                    }
                }
            }else{
                $validator->setCustomMessages(['check_product_id_list' => 'product_id_list must be a array!']);
                return false;
            }
            return true;
        });

        $validator = Validator::make($data, [
            'product_id_list'=>'required|check_product_id_list',
            'status'=>'required|in:selling,in_the_warehouse',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }
        $product_id_list = $request->input('product_id_list');

        $product_obj = Products::where('company_id',Auth::user()->company->id)->whereIn('id',$product_id_list)->get();

        foreach ($product_obj as $v){
            if($v->product_status == self::PRODUCT_STATUS_SALE){
                $v->product_status = self::PRODUCT_STATUS_WAREHOUSE; //放入仓库
            }elseif ($v->product_status == self::PRODUCT_STATUS_WAREHOUSE){
                $v->product_status = self::PRODUCT_STATUS_SALE;
                $v->product_audit_status = self::PRODUCT_AUDIT_STATUS_CHECKING;
            }
            $v->save();
        }

        $status = $request->input('status');
        $res_data = self::getStatusProductData($status);
        return $this->echoSuccessJson('操作成功!',['data_list'=>$res_data,'total'=>count($res_data)]);
    }

    public function productSearch(Request $request){
        $keywords = $request->input('keywords');

        $categories_list = ProductsCategories::where('name', 'like','%'.$keywords.'%')->get()->pluck('id')->toArray();
        $products_attr_id_list = ProductsAttr::where('attr_specs', 'like','%'.$keywords.'%')->pluck('id')->toArray();

        $products = Products::where(
            'product_name','like','%'.$keywords.'%'
        )->orWhere(
            'product_keywords','like','%'.$keywords.'%'
        )->orWhereIn(
            'product_attr_id',$products_attr_id_list
        )->orWhereIn(
            'product_categories_id',$categories_list
        );


        if(!$products->get()->isEmpty()){
            $res = self::getProductFormatInfo($products);
            return $this->echoSuccessJson('搜索成功!',$res);
        }else{
            return $this->echoErrorJson('没有搜索到商品!');
        }
    }

}