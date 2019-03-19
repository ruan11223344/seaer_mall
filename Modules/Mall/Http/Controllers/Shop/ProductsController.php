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
use Modules\Admin\Entities\ProductAudit;
use Modules\Admin\Entities\UserLog;
use Modules\Admin\Service\UtilsService;
use Modules\Mall\Entities\AlbumPhoto;
use Modules\Mall\Entities\AlbumUser;
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

    const PUBLISH_PRODUCT_STATUS_NOT_AUDIT    = 0; //不可发布 未审核
    const PUBLISH_PRODUCT_STATUS_NORMAL       = 1; //可发布
    const PUBLISH_PRODUCT_STATUS_CHECKING     = 2; //审核中
    const PUBLISH_PRODUCT_STATUS_NOT_APPROVED = 3; //审核被退回
    const PUBLISH_PRODUCT_STATUS_BANNED       = 4; //被封禁

    const PRODUCT_STATUS_SALE      = 1; //商品正常售卖中
    const PRODUCT_STATUS_WAREHOUSE = 2; //在仓库中

    const PRODUCT_AUDIT_STATUS_CHECKING = 0; //商品审核中
    const PRODUCT_AUDIT_STATUS_SUCCESS  = 1; //商品审核成功
    const PRODUCT_AUDIT_STATUS_FAIL     = 2; //商品审核未通过

    /**
     * 获取商品发布的权限
     *
     * @return json
     */
    public function checkPublishProductPermissions()
    {
        //检测是否有商品发布权
        $pub_status_msg = self::getPublishProductPermissions();
        return $this->echoSuccessJson('Obtain the commodity publishing permission Success!', ['publish_product_permission' => $pub_status_msg[0], 'publish_product_permission_message' => $pub_status_msg[1]]);
    }

    /**
     * 获取商品发布的权限
     *
     * @return array
     */
    public static function getPublishProductPermissions()
    {
        $pub_status = Auth::user()->usersExtends->publish_product_status;
        $message    = '';
        switch ($pub_status) {
            case self::PUBLISH_PRODUCT_STATUS_NOT_AUDIT:
                $message = '从未提交审核店铺资料,不能发布商品!';
                $status  = false;
                break;
            case self::PUBLISH_PRODUCT_STATUS_NORMAL:
                $message = '店铺资料通过审核可以发布商品!';
                $status  = true;
                break;
            case self::PUBLISH_PRODUCT_STATUS_CHECKING:
                $message = '店铺资料正在审核中,暂时无法发布商品!';
                $status  = false;
                break;
            case self::PUBLISH_PRODUCT_STATUS_NOT_APPROVED:
                $message = '店铺资料审核被退回,请重新提交审核,暂时无法发布商品!';
                $status  = false;
                break;
            case self::PUBLISH_PRODUCT_STATUS_BANNED:
                $message = '店铺被封禁,无法发布商品!';
                $status  = false;
                break;
        }

        return [$status, $message];
    }

    public static function createProductOriginId($user_obj)
    {
        if ($user_obj->usersExtends->account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA) {
            $region = 'CN';
        } elseif ($user_obj->usersExtends->account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_KENYA) {
            $region = 'KE';
        }
        $af_id_end = substr($user_obj->usersExtends->af_id, 7, 10);
        $pd_str    = 'PD_' . $region . '_' . $af_id_end . '_';
        $pd_str .= substr(Uuid::generate(), 0, 8);
        return $pd_str;
    }

    public function publishProduct(Request $request)
    {

        $data = $request->all();

        Validator::extend('publishing_time', function ($attribute, $value, $parameters, $validator) {
            if ($value == null) {
                return true;
            } else {
                if (Carbon::parse($value)->timestamp < time()) {
                    $validator->setCustomMessages(['publishing_time' => 'You can only choose the time in the future!']);
                    return false;
                } else {
                    return true;
                }
            }
        });

        $validator = Validator::make($data, [
            'product_name'            => 'required',
            'product_sku_no'          => 'required',
            'product_keywords'        => 'required|array',
            'product_images'          => 'required|array',
            'product_attr'            => 'required|array',
            'product_price'           => 'required|array',
            'product_price_type'      => 'required|in:base,ladder',
            'product_details'         => 'nullable',
            'product_publishing_time' => 'publishing_time',
            'product_categories_id'   => 'required|exists:products_categories,id',
            'product_group_id'        => 'nullable|exists:products_group,id',
            'product_put_warehouse'   => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $pub_status    = self::getPublishProductPermissions();
        $put_warehouse = $request->input('product_put_warehouse');

        if ($request->input('product_publishing_time') !== null) {
            $carbon_obj              = Carbon::parse($request->input('product_publishing_time'));
            $product_publishing_time = $carbon_obj->toDateTimeString();
        } else {
            $product_publishing_time = null;
        }

        if (($pub_status[0] == false && $put_warehouse == false) || ($pub_status[0] == false && $product_publishing_time !== null)) {
            return $this->echoErrorJson('Cannot publish merchandise ! Details:: ' . $pub_status[1]);
        }

        $product_name          = $request->input('product_name');
        $product_categories_id = $request->input('product_categories_id');
        $product_sku_no        = $request->input('product_sku_no');
        $product_keywords      = $request->input('product_keywords');
        $product_group_id      = $request->input('product_group_id');
        $product_attr          = $request->input('product_attr');
        $product_images        = $request->input('product_images');

        try {
            if (Products::where([
                ['product_name', '=', $product_name],
                ['company_id', '=', Auth::user()->company->id],
            ])->exists()) {
                return $this->echoErrorJson('Error!Warehouse or in the sale of goods with the same name!Unable to publish!');
            }

            DB::beginTransaction();
            $price_type    = $request->input('product_price_type');
            $product_price = $request->input('product_price');

            if ($price_type == 'ladder') {
                foreach ($product_price as $v) {
                    if (!(isset($v['unit']) && isset($v['min_order']) && isset($v['order_price']))) {
                        return $this->echoErrorJson('There is a wrong price ladder!');
                    }
                }
            } elseif ($price_type == 'base') {
                foreach ($product_price as $v) {
                    if (!(isset($v['unit']) && isset($v['min_order']) && isset($v['max_order_price']) && isset($v['min_order_price']))) {
                        return $this->echoErrorJson('Base price format error!The lack of object!');
                    }

                    if ($v['max_order_price'] < $v['min_order_price']) {
                        return $this->echoErrorJson('Base price the maximum price cannot be less than the minimum price!');
                    }
                }
            }

            $product_price_model = ProductsPrice::create(
                [
                    'price_type'   => $price_type,
                    'base_price'   => $price_type == 'base' ? $product_price : null,
                    'ladder_price' => $price_type == 'ladder' ? $product_price : null,
                ]
            );

            if ($product_attr !== null) {
                $product_attr_model = ProductsAttr::create(
                    [
                        'attr_specs' => $product_attr,
                    ]
                );
            }

            $product_model = Products::create(
                [
                    'product_name'            => $product_name,
                    'product_categories_id'   => $product_categories_id,
                    'product_sku_no'          => $product_sku_no,
                    'product_keywords'        => $product_keywords,
                    'product_images'          => $product_images,
                    'product_status'          => $product_publishing_time != null ? self::PRODUCT_STATUS_SALE : $put_warehouse == true ? self::PRODUCT_STATUS_WAREHOUSE : self::PRODUCT_STATUS_SALE,
                    'product_publishing_time' => $product_publishing_time,
                    'product_price_id'        => $product_price_model->id,
                    'product_attr_id'         => $product_attr == null ? null : $product_attr_model->id,
                    'product_details'         => $request->input('product_details', null),
                    'product_audit_status'    => self::PRODUCT_AUDIT_STATUS_CHECKING,
                    'company_id'              => Auth::user()->company->id,
                    'product_origin_id'       => self::createProductOriginId(Auth::user()),
                ]
            );
            //商品分组
            if ($product_group_id !== null) {
                ProductsProductsGroup::create(
                    [
                        'product_id'       => $product_model->id,
                        'product_group_id' => $product_group_id,
                    ]
                );
            }

            if (($product_publishing_time != null ? self::PRODUCT_STATUS_SALE : $put_warehouse == true ? self::PRODUCT_STATUS_WAREHOUSE : self::PRODUCT_STATUS_SALE) == self::PRODUCT_STATUS_SALE) {
                ProductAudit::create(
                    [
                        'product_id' => $product_model->id,
                        'status'     => 'waiting',
                    ]
                );
            }

            DB::commit();
            return $this->echoSuccessJson('Product creation successful!');
        } catch (Exception $e) {
            DB::rollback();
            return $this->echoErrorJson('Failed to create the item!The error message: ' . $e->getMessage());
        }
    }

    public function uploadProductImg(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'product_img' => 'image|max:1024|required',
            'where'       => 'required|in:main,1,2,3,4',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $img = UtilsController::uploadFile($data['product_img'], UtilsController::getUserProductDirectory(), true);
        return $this->echoSuccessJson('Upload Success!', ['img_path' => $img['path'], 'img_url' => $img['url'], 'where' => $request->input('where')]);
    }

    public function editProduct(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'product_id'              => 'required|exists:products,id',
            'product_name'            => 'nullable',
            'product_sku_no'          => 'nullable',
            'product_keywords'        => 'nullable|array',
            'product_images'          => 'nullable|array',
            'product_attr'            => 'nullable|array',
            'product_price'           => 'nullable|array',
            'product_price_type'      => 'nullable|in:base,ladder',
            'product_details'         => 'nullable',
            'product_publishing_time' => 'nullable',
            'product_categories_id'   => 'nullable|exists:products_categories,id',
            'product_group_id'        => 'nullable|exists:products_group,id',
            'product_put_warehouse'   => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $product_obj = Products::find($request->input('product_id'));

        if ($product_obj == null) {
            return $this->echoErrorJson('Error!This product does not exist!');
        }

        if ($product_obj->company_id != Auth::user()->company->id) {
            return $this->echoErrorJson('You can only edit your own merchandise!');
        }

        $price_type              = $request->input('product_price_type', null);
        $product_price           = $request->input('product_price', null);
        $product_attr            = $request->input('product_attr', null);
        $product_name            = $request->input('product_name', null);
        $product_categories_id   = $request->input('product_categories_id', null);
        $product_sku_no          = $request->input('product_sku_no', null);
        $product_keywords        = $request->input('product_keywords', null);
        $product_group_id        = $request->input('product_group_id', null);
        $product_images          = $request->input('product_images', null);
        $put_warehouse           = $request->input('product_put_warehouse', null);
        $product_publishing_time = $request->input('product_publishing_time', null);
        $product_details         = $request->input('product_details', null);

        try {
            DB::beginTransaction();

            if ($product_publishing_time == null) {
                DB::table('products')->where('id', $product_obj->id)->update([
                    'product_publishing_time' => null,
                ]);
            }

            if ($product_name !== null) {
                if (Products::where(
                    [
                        ['company_id', '=', Auth::user()->company->id],
                        ['product_name', '=', $product_name],
                        ['id', '!=', $product_obj->id],
                    ]
                )->exists()) {
                    return $this->echoErrorJson('Error!The same name of the existence of goods, can not use the name of the goods!');
                }
            }

            //更新价格
            if ($price_type !== null && $product_price !== null) {
                if ($price_type == 'ladder') {
                    foreach ($product_price as $v) {
                        if (!(isset($v['unit']) && isset($v['min_order']) && isset($v['order_price']))) {
                            return $this->echoErrorJson('There is a wrong price ladder!');
                        }
                    }
                } elseif ($price_type == 'base') {
                    foreach ($product_price as $v) {
                        if (!(isset($v['unit']) && isset($v['min_order']) && isset($v['max_order_price']) && isset($v['min_order_price']))) {
                            return $this->echoErrorJson('Base price format error!The lack of object!');
                        }
                    }
                }

                $product_obj->products_price->update(
                    [
                        'price_type'   => $price_type,
                        'base_price'   => $price_type == 'base' ? $product_price : null,
                        'ladder_price' => $price_type == 'ladder' ? $product_price : null,
                    ]
                );
            }

            //更新属性
            if ($product_attr !== null) {
                $product_obj->products_attr->update(
                    [
                        'attr_specs' => $product_attr,
                    ]
                );
            }

            if ($product_publishing_time !== null) {
                $carbon_obj = Carbon::parse($request->input('product_publishing_time'));
                if ($carbon_obj->timestamp + 1200 < time()) {
                    return $this->echoErrorJson('Timed release time can only be in the future!');
                }
                $product_publishing_time = $carbon_obj->toDateTimeString();
            }

            $update_data = [
                'product_name'            => $product_name,
                'product_categories_id'   => $product_categories_id,
                'product_sku_no'          => $product_sku_no,
                'product_keywords'        => $product_keywords,
                'product_images'          => $product_images,
                'product_status'          => $product_publishing_time != null ? self::PRODUCT_STATUS_SALE : $put_warehouse == null ? null : $put_warehouse == true ? self::PRODUCT_STATUS_WAREHOUSE : self::PRODUCT_STATUS_SALE,
                'product_publishing_time' => $product_publishing_time,
                'product_details'         => $product_details,
//                'product_audit_status'    => self::PRODUCT_AUDIT_STATUS_CHECKING, //0 也 等于 null 所以状态没有被更新 下方加入判断后更新审核状态
            ];

            foreach ($update_data as $k => $v) {
                if ($v == null) {
                    unset($update_data[$k]);
                }
            }

            foreach ($update_data as $k=>$v){
                if($product_obj->$k != $v){
                    $changed = true;
                    break;
                }else{
                    $changed = false;
                }
            }

            if($changed){
                $update_data['product_audit_status'] = self::PRODUCT_AUDIT_STATUS_CHECKING;
            }

            //更新商品
            $product_obj->update($update_data);

            //更新分组
            if ($product_group_id !== null) {
                $p_group = ProductsGroup::find($product_group_id);
                if ($p_group == null) {
                    return $this->echoErrorJson('Error, item grouping id does not exist!');
                } else {
                    if ($p_group->user_id != Auth::id()) {
                        return $this->echoErrorJson('Error, the item group does not belong to this user!');
                    } else {
                        if (!ProductsProductsGroup::where('product_id', $product_obj->id)->exists()) {
                            ProductsProductsGroup::create(
                                [
                                    'product_id'       => $product_obj->id,
                                    'product_group_id' => $product_group_id,
                                ]
                            );
                        } else {
                            $product_obj->products_products_group->update(
                                ['product_group_id' => $product_group_id]
                            );
                        }
                    }
                }
            }

            if (($product_publishing_time != null ? self::PRODUCT_STATUS_SALE : $put_warehouse == null ? null : $put_warehouse == true ? self::PRODUCT_STATUS_WAREHOUSE : self::PRODUCT_STATUS_SALE) == self::PRODUCT_STATUS_SALE) {
                ProductAudit::create(
                    [
                        'product_id' => $product_obj->id,
                        'status'     => 'waiting',
                    ]
                );
            }

            $company_id = $product_obj->company_id;

            if($company_id != null){
                if(UsersExtends::where('company_id',$company_id)->exists()){
                    $user_id = UsersExtends::where('company_id',$company_id)->get()->first()->user_id;
                    UtilsService::WriteLog('user','product','modify',$user_id,$product_obj->id); //记录修改商品日志
                }
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return $this->echoErrorJson('Database error details:' . $e->getMessage());
        }

        return $this->echoSuccessJson('The editor updated the item successfully!');
    }

    public function deleteProduct(Request $request)
    {
        $data = $request->all();

        Validator::extend('product_id_list', function ($attribute, $value, $parameters, $validator) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    if (Products::find($v) == null) {
                        $validator->setCustomMessages(['product_id_list' => "product_id don't exists !id:" . $v]);
                        return false;
                    }
                }
            } else {
                $validator->setCustomMessages(['product_id_list' => 'product_id_list must be a array!']);
                return false;
            }
            return true;
        });

        $validator = Validator::make($data, [
            'product_id_list' => 'required|product_id_list',
            'status'          => 'required|in:selling,check_pending,unapprove,in_the_warehouse',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $product_id_list = $request->input('product_id_list');

        $product_obj = Products::whereIn('id', $product_id_list)->get();

        foreach ($product_obj as $v) {
            if ($v == null) {
                return $this->echoErrorJson('Error!The goods do not exist!');
            }

            if ($v->company_id != Auth::user()->company->id) {
                return $this->echoErrorJson('Can only delete their own goods!');
            }

            $v->products_attr->delete();
            $v->products_price->delete();
            $v->delete();
        }

        $status = $request->input('status');

        $res = self::getStatusProductData($status);

        return $this->echoSuccessJson('Delete product Success!', ['data_list' => $res, 'total' => count($res)]);

    }

    public static function getStatusProductData($status_str)
    {
        $products_orm = Products::where('company_id', Auth::user()->company->id);
        switch ($status_str) {
            case 'selling':
                $products_orm->where('product_status', self::PRODUCT_STATUS_SALE)->where('product_audit_status', self::PRODUCT_AUDIT_STATUS_SUCCESS);
                break;
            case 'check_pending':
                $products_orm->where('product_audit_status', self::PRODUCT_AUDIT_STATUS_CHECKING)->where('product_status', self::PRODUCT_STATUS_SALE);
                break;
            case 'unapprove':
                $products_orm->where('product_audit_status', self::PRODUCT_AUDIT_STATUS_FAIL);
                break;
            case 'in_the_warehouse':
                $products_orm->where('product_status', self::PRODUCT_STATUS_WAREHOUSE);
                break;
        }

        if ($products_orm->count() == 0) {
            return [];
        }

        $res = self::getProductFormatInfo($products_orm);

        return $res;
    }

    public function getProductList(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'status' => 'required|in:selling,check_pending,unapprove,in_the_warehouse',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $status = $request->input('status');

        $res = self::getStatusProductData($status);

        return $this->echoSuccessJson('Get the list of items as Success!', ['data_list' => $res, 'total' => count($res)]);
    }

    public function getProductDetail(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $product_id = $request->input('product_id');

        $product_obj = Products::find($product_id);

        if ($product_obj == null) {
            return $this->echoErrorJson('The goods do not exist!');
        }

        $products_attr      = $product_obj->products_attr;
        $products_price     = $product_obj->products_price;
        $attr_arr           = $products_attr->toArray()['attr_specs'];
        $product_attr_array = array();

        $product_price_array = $products_price->toArray();
        $price_array         = [];
        if ($product_price_array['price_type'] == 'base') {
            $tmp          = [];
            $tmp['unit']  = $product_price_array['base_price'][0]['unit'];
            $tmp['moq']   = 'MOQ: ' . $product_price_array['base_price'][0]['min_order'] . ' ' . $tmp['unit'];
            $tmp['price'] = $product_price_array['base_price'][0]['min_order_price'];
            array_push($price_array, $tmp);
        } elseif ($product_price_array['price_type'] == 'ladder') {
            foreach ($product_price_array['ladder_price'] as $v) {
                $re_order = array_column($product_price_array['ladder_price'], 'min_order');
                array_multisort($re_order, SORT_ASC, $product_price_array['ladder_price']);
                for ($i = 0; $i < count($product_price_array['ladder_price']); $i++) {
                    $tmp = [];
                    if ($i < count($product_price_array['ladder_price']) - 1) {
                        $min_order    = $product_price_array['ladder_price'][$i]['min_order'];
                        $max_order    = ($product_price_array['ladder_price'][$i + 1]['min_order']);
                        $tmp['moq']   = $i == 0 ? 'MOQ: ' . $min_order . '-' . $max_order . ' ' . $product_price_array['ladder_price'][$i]['unit'] : 'MOQ: ' . ($min_order + 1) . '-' . $max_order . ' ' . $product_price_array['ladder_price'][$i]['unit'];
                        $tmp['unit']  = $v['unit'];
                        $tmp['price'] = $product_price_array['ladder_price'][$i]['order_price'];
                    } else {
                        $tmp['moq']   = 'MOQ: ≥' . '' . ($product_price_array['ladder_price'][$i]['min_order'] + 1);
                        $tmp['unit']  = $v['unit'];
                        $tmp['price'] = $product_price_array['ladder_price'][$i]['order_price'];
                    }
                    if (!in_array($tmp, $price_array)) {
                        array_push($price_array, $tmp);
                    }
                }
            }

        }

        if (count($attr_arr) > 0) {
            foreach ($attr_arr as $item) {
                $attr                                                                                                                                   = array_values($item)[0];
                $attr_key                                                                                                                               = array_keys($item)[0];
                array_key_exists($attr_key, $product_attr_array) ? array_push($product_attr_array[$attr_key], $attr) : $product_attr_array[$attr_key][] = $attr;
            }
        }

        $product_info                = $product_obj->toArray();
        $product_info['status_str']  = '';
        $product_info['price_array'] = $price_array;
        if ($product_info['product_status'] == self::PRODUCT_STATUS_SALE) {
            $product_info['status_str'] = 'Release';
        }

        if ($product_info['product_status'] == self::PRODUCT_STATUS_WAREHOUSE) {
            $product_info['status_str'] = 'Put';
        }

        if ($product_info['product_publishing_time'] != null) {
            $product_info['status_str'] = 'Time';
        }
        $product_group                             = ProductsProductsGroup::where('product_id', $product_id)->get()->first();
        $product_info['product_group_id']          = $product_group != null ? $product_group->product_group_id : null;
        $product_info['product_group_name']        = $product_group != null ? ProductsGroup::find($product_group->product_group_id)->group_name : null;
        $product_group_p_id                        = $product_group == null ? null : ProductsGroup::find($product_group->product_group_id)->parent_id;
        $product_info['product_group_parent_id']   = $product_group == null ? null : $product_group_p_id == 0 ? null : $product_group_p_id;
        $product_info['product_group_parent_name'] = $product_group_p_id == null ? null : ProductsGroup::find($product_group->product_group_id)->group_name;
        $product_info['product_images_url']        = [];
        foreach ($product_info['product_images'] as $v) {
            array_push($product_info['product_images_url'], UtilsController::getPathFileUrl(array_values($v)[0]));
        }

        $product_info['product_group_parent_child_id'] = [];

        if ($product_info['product_group_parent_id'] != null) {
            array_push($product_info['product_group_parent_child_id'], $product_info['product_group_parent_id']);
        }

        if ($product_info['product_group_id'] != null) {
            array_push($product_info['product_group_parent_child_id'], $product_info['product_group_id']);
        }

        $product_format_info = self::getProductFormatInfo(Products::where('id', $product_id));

        $user_id = $request->input('user_id', null);

        if ($user_id == null) {
            $is_favorites_shop    = false;
            $is_favorites_product = false;
        } else {
            UtilsService::WriteLog('user','product','visit',$user_id,$product_id); //记录浏览商品日志
            $is_favorites_product = Favorites::where(
                [
                    ['company_id', '=', User::find($user_id)->company->id],
                    ['type', '=', 'product'],
                    ['product_or_company_id', '=', $product_id],
                ]
            )->exists();
            $is_favorites_shop = Favorites::where(
                [
                    ['company_id', '=', User::find($user_id)->company->id],
                    ['type', '=', 'company'],
                    ['product_or_company_id', '=', $product_info['company_id']],
                ]
            )->exists();

        }

        $res = ['product_info' => $product_info, 'product_attr' => $products_attr->toArray(), 'product_price' => $products_price->toArray(), 'product_attr_array' => $product_attr_array, 'product_format_info' => $product_format_info, 'is_favorites_shop' => $is_favorites_shop, 'is_favorites_product' => $is_favorites_product];

        return $this->echoSuccessJson('Obtain product details from Success!', $res);
    }

    public static function getProductFormatInfo($products_orm)
    {
        $res = [];
        $products_orm->get()->map(function ($v, $k) use (&$res) {

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

            $item = [
                'product_id'           => $v->id,
                'product_name'         => $v->product_name,
                'product_sku'          => $v->product_sku_no,
                'product_price'        => $product_price,
                'price_type'           => $price_type,
                'product_moq'          => $product_moq,
                'publish_time'         => $v->updated_at != null ? Carbon::parse($v->updated_at)->toDateTimeString() : Carbon::parse($v->created_at)->toDateTimeString(),
                'product_main_pic_url' => UtilsController::getPathFileUrl($v->product_images[0]['main']),
                'product_origin_id'    => $v->product_origin_id,
                'company_id'           => $v->company_id,
            ];
            array_push($res, $item);
        });

        return $res;
    }

    public function changeProductsWarehouse(Request $request)
    {
        $data = $request->all();

        Validator::extend('check_product_id_list', function ($attribute, $value, $parameters, $validator) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    if (Products::find($v) == null) {
                        $validator->setCustomMessages(['check_product_id_list' => "product_id don't exists, id:" . $v]);
                        return false;
                    }
                }
            } else {
                $validator->setCustomMessages(['check_product_id_list' => 'product_id_list must be a array!']);
                return false;
            }
            return true;
        });

        $validator = Validator::make($data, [
            'product_id_list' => 'required|check_product_id_list',
            'status'          => 'required|in:selling,in_the_warehouse',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }
        $product_id_list = $request->input('product_id_list');

        $product_obj = Products::where('company_id', Auth::user()->company->id)->whereIn('id', $product_id_list)->get();

        foreach ($product_obj as $v) {
            if ($v->product_status == self::PRODUCT_STATUS_SALE) {
                $v->product_status = self::PRODUCT_STATUS_WAREHOUSE; //放入仓库
            } elseif ($v->product_status == self::PRODUCT_STATUS_WAREHOUSE) {
                $v->product_status       = self::PRODUCT_STATUS_SALE;
                $v->product_audit_status = self::PRODUCT_AUDIT_STATUS_CHECKING;
                ProductAudit::create(
                    [
                        'product_id' => $v->id,
                        'status'     => 'waiting',
                    ]
                );
            }
            $v->save();
        }

        $status   = $request->input('status');
        $res_data = self::getStatusProductData($status);
        return $this->echoSuccessJson('操作Success!', ['data_list' => $res_data, 'total' => count($res_data)]);
    }

    public function productSearch(Request $request)
    {
        $keywords = $request->input('keywords');

        $categories_list       = ProductsCategories::where('name', 'like', '%' . $keywords . '%')->get()->pluck('id')->toArray();
        $products_attr_id_list = ProductsAttr::where('attr_specs', 'like', '%' . $keywords . '%')->pluck('id')->toArray();

        $products = Products::where(
            'product_name', 'like', '%' . $keywords . '%'
        )->orWhere(
            'product_keywords', 'like', '%' . $keywords . '%'
        )->orWhereIn(
            'product_attr_id', $products_attr_id_list
        )->orWhereIn(
            'product_categories_id', $categories_list
        );

        if (!$products->get()->isEmpty()) {
            $res = self::getProductFormatInfo($products);
            return $this->echoSuccessJson('Search success!', $res);
        } else {
            return $this->echoErrorJson('No item was found!');
        }
    }

    public function ProductNumInfo()
    {
        $data                         = [];
        $user_obj                     = Auth::user();
        $product_orm                  = Products::where('company_id', $user_obj->company->id);
        $product_num_info_str         = clone $product_orm;
        $product_selling_num          = clone $product_orm;
        $product_in_the_warehouse_num = clone $product_orm;
        $product_check_pending_num    = clone $product_orm;
        $product_unapprove_num        = clone $product_orm;

        $data['product_num_info_str'] = $product_num_info_str->count() . '/200';
        $data['image_info_str']       = AlbumPhoto::whereIn('album_id', AlbumUser::where('user_id', $user_obj->id)->where('soft_delete', 0)->get()->pluck('id'))->where(
            'soft_delete', 0
        )->count() . '/3000';
        $data['product_selling_num']          = $product_selling_num->where('product_status', self::PRODUCT_STATUS_SALE)->where('product_audit_status', self::PRODUCT_AUDIT_STATUS_SUCCESS)->count();
        $data['product_in_the_warehouse_num'] = $product_in_the_warehouse_num->where('product_status', self::PRODUCT_STATUS_WAREHOUSE)->count();
        $data['product_check_pending_num']    = $product_check_pending_num->where('product_status', self::PRODUCT_STATUS_SALE)->where('product_audit_status', self::PRODUCT_AUDIT_STATUS_CHECKING)->count();
        $data['product_unapprove_num']        = $product_unapprove_num->where('product_status', self::PRODUCT_STATUS_SALE)->where('product_audit_status', self::PRODUCT_AUDIT_STATUS_FAIL)->count();

        return $this->echoSuccessJson('Success', $data);
    }

}
