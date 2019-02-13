<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers;
use App\Utils\City;
use App\Utils\EchoJson;
use App\Utils\Oss;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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


}