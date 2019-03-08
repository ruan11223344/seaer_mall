<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\AdminLog;
use Modules\Admin\Entities\Role;
use Modules\Admin\Entities\UserLog;
use Modules\Admin\Service\UtilsService;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\User;
use Modules\Mall\Http\Controllers\Shop\ProductsController;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class UserManagerController extends Controller
{
    use EchoJson;

    public static function getUserData($user_orm,$page,$size){
        $user_status_list = [
            ProductsController::PUBLISH_PRODUCT_STATUS_NOT_AUDIT,
            ProductsController::PUBLISH_PRODUCT_STATUS_CHECKING,
            ProductsController::PUBLISH_PRODUCT_STATUS_NOT_APPROVED,
            ProductsController::PUBLISH_PRODUCT_STATUS_BANNED,
        ];


        $user_data_list = [];
        $user_orm_clone = clone $user_orm;
        $count = $user_orm_clone->whereIn('users_extends.publish_product_status',$user_status_list)->count();
        $user_orm->whereIn('users_extends.publish_product_status',$user_status_list)->offset(($page-1)*$size)->limit($size)->get()->map(function ($v,$k)use(&$user_data_list,$page,$size,$user_status_list){
            $tmp = [];
            $tmp['num'] = $k+1+(($page-1)*$size);//序号
            $tmp['user_id'] = $v->user_id;//序号
            $tmp['register_time'] = Carbon::parse($v->created_at)->format('Y-m-d');//序号
            $tmp['af_id'] = $v->af_id;//序号
            $tmp['member_id'] = $v->name;//序号
            $tmp['email'] = $v->email;//序号
            $tmp['contact_full_name'] = $v->contact_full_name;//序号
            $tmp['sex'] = $v->sex;//序号
            $tmp['phone_num'] = $v->mobile_phone;//序号
            $tmp['address'] = $v->detailed_address;//序号
            $user_log = UserLog::where('user_id',$v->id)->orderBy('created_at','desc');
            $tmp['last_login'] = $user_log->exists() ? Carbon::parse($user_log->get()->first()->created_at)->format('Y-m-d') : '';//序号
            $tmp['allow_inquiry'] = $v->allow_inquiry == 1 ? true : false;//序号
            array_push($user_data_list,$tmp);
        });
        $res_data = [];
        $res_data['data'] = $user_data_list;
        $res_data['size'] = $size;
        $res_data['cur_page'] =$page;
        $res_data['total_page'] = (int)ceil($count/$size);
        $res_data['total_size'] = $count;
        return $res_data;
    }

    public function getUserList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $page = $request->input('page',1);
        $size = $request->input('size',20);

        UtilsService::CreatePermissions('访问用户列表','访问afriby非商家的用户列表');
        $res_data = self::getUserData(User::join('users_extends', function ($join) {
            $join->on('users.id', '=','users_extends.user_id');
        })->select('users.id as user_id')->select('users.*')->select('users_extends.*'),$page,$size);

        return $this->echoSuccessJson('成功!',$res_data);
    }

    public function searchUserList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
            'keywords'=>'required'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $page = $request->input('page',1);
        $size = $request->input('size',20);
        $keywords = $request->input('keywords','');
        UtilsService::CreatePermissions('搜索用户列表','搜索afriby非商家的用户列表');
        $res_data = self::getUserData(User::join('users_extends', function ($join) {
            $join->on('users.id', '=','users_extends.user_id');
        })->where('name', 'like','%'.$keywords.'%')->orWhere('email','like','%'.$keywords.'%')->select('users.id as user_id')->select('users.*')->select('users_extends.*'),$page,$size);

        return $this->echoSuccessJson('成功!',$res_data);
    }

    public function setInquiry(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id'=>'required|exists:users,id',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        UtilsService::CreatePermissions('设置询盘','设置用户是否能够发送询盘');

        $user_id = $request->input('user_id');
        $user_obj = User::where('id',$user_id)->get()->first();
        $userEx  = $user_obj->usersExtends;

        $userEx->allow_inquiry = $userEx->allow_inquiry == true ? false : true;
        $userEx->save();

        return $this->echoSuccessJson('设置用户询盘成功!',['user_id'=>$user_id,'allow_inquiry'=>$userEx->allow_inquiry]);
    }

    public static function getMerchantData($merchant_orm,$page,$size){
        $user_status_list = [
            ProductsController::PUBLISH_PRODUCT_STATUS_NORMAL,
        ];
        $user_data_list = [];
        $merchant_orm_clone  = clone $merchant_orm;
        $count = $merchant_orm_clone->whereIn('users_extends.publish_product_status',$user_status_list)->count();

        $merchant_orm->whereIn('users_extends.publish_product_status',$user_status_list)->offset(($page-1)*$size)->limit($size)->get()->map(function ($v,$k)use(&$user_data_list,$page,$size,$user_status_list){
            $tmp = [];
            $tmp['num'] = $k+1+(($page-1)*$size);//序号
            $tmp['user_id'] = $v->user_id;//序号
            $open_shop_time = AdminLog::where(
                [
                    ['type_for_id','=',$v->company_id],
                    ['type','=','audit_company'],
                    ['action','=','allow'],
                ]
            )->orderBy('created_at','asc');

            $tmp['open_shop_time'] = $open_shop_time->exists() ? Carbon::parse($open_shop_time->get()->first()->created_at)->format('Y-m-d')  : "";//序号
            $tmp['company_name'] = $v->company_name;
            $tmp['contact_full_name'] = $v->contact_full_name;//序号
            $tmp['sex'] = $v->sex;//序号
            $tmp['phone_num'] = $v->mobile_phone;//序号
            $tmp['email'] = $v->email;//序号
            $tmp['address'] = $v->detailed_address;//序号
            $product = Products::where(
                [
                    ['product_status','=',ProductsController::PRODUCT_STATUS_SALE],
                    ['product_audit_status','=',ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS],
                    ['company_id','=',$v->company_id],
                ]
            );
            $tmp['product_num'] = $product->exists() ? $product->count() : 0;//序号
            $user_log = UserLog::where('user_id',$v->id)->orderBy('created_at','desc');
            $tmp['last_login'] = $user_log->exists() ? Carbon::parse($user_log->get()->first()->created_at)->format('Y-m-d') : '';//序号
            $tmp['allow_inquiry'] = $v->allow_inquiry == 1 ? true : false;//序号
            array_push($user_data_list,$tmp);
        });
        $res_data = [];
        $res_data['data'] = $user_data_list;
        $res_data['size'] = $size;
        $res_data['cur_page'] =$page;
        $res_data['total_page'] = (int)ceil($count/$size);
        $res_data['total_size'] = $count;
        return $res_data;
    }

    public function getMerchantsList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        UtilsService::CreatePermissions('获取商家列表','管理员是否能够获取商家列表');


        $page = $request->input('page',1);
        $size = $request->input('size',20);

        $user_company_orm = User::join('users_extends', function ($join) {
            $join->on('users.id', '=','users_extends.user_id');
        })->join('company', function ($join) {
            $join->on('users.id', '=','company.user_id');
        });

        $res_data = self::getMerchantData($user_company_orm,$page,$size);

        return $this->echoSuccessJson('成功!',$res_data);

    }

    public function searchMerchantsList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
            'keywords'=>'required'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        UtilsService::CreatePermissions('搜索商家列表','管理员是否能够获取商家列表');

        $page = $request->input('page',1);
        $size = $request->input('size',20);
        $keywords = $request->input('keywords');

        $user_company_orm = User::join('users_extends', function ($join) {
            $join->on('users.id', '=','users_extends.user_id');
        })->join('company', function ($join) {
            $join->on('users.id', '=','company.user_id');
        })->where('users.name', 'like','%'.$keywords.'%')->orWhere('users.email','like','%'.$keywords.'%');

        $res_data = self::getMerchantData($user_company_orm,$page,$size);

        return $this->echoSuccessJson('成功!',$res_data);

    }

    public function getAdminList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        UtilsService::CreatePermissions('获取管理员列表','获取管理员列表详情');


        $page = $request->input('page',1);
        $size = $request->input('size',20);
        $admin = new Admin();
        $count = $admin->count();

        $admin_data_list =[];
        $admin->get()->map(function ($v,$k)use(&$admin_data_list,$page,$size){
            $tmp = [];
            $tmp['num'] = $k+1+(($page-1)*$size);//序号
            $tmp['admin_name'] = $v->name;//序号
            $admin_log = AdminLog::where(
                [
                    ['admin_id','=',$v->id],
                    ['type','=','auth'],
                    ['action','=','login']
                ]
            )->orderBy('created_at','desc');
            $admin_log_clone = clone $admin_log;
            $tmp['last_login'] = $admin_log->exists() ? Carbon::parse($admin_log->get()->first()->created_at)->format('Y-m-d') : '';//序号
            $tmp['login_count'] = $admin_log_clone->count();//序号
            $tmp['role_name'] = $v->roles()->exists() ? $v->roles()->get()->first()->name : "";
            array_push($admin_data_list,$tmp);
        });


        $res_data['data'] = $admin_data_list;
        $res_data['size'] = $size;
        $res_data['cur_page'] =$page;
        $res_data['total_page'] = (int)ceil($count/$size);
        $res_data['total_size'] = $count;
        return $this->echoSuccessJson('获取管理员列表成功!',$res_data);
    }

    public static function getAdminData($admin_id){
        $admin_obj = Admin::find($admin_id);
        $admin_role_info = $admin_obj->roles()->exists() ? $admin_obj->roles()->get()->first() : null;
        $res_data = [
            'admin_name'=>$admin_obj->name,
            'role_name'=>$admin_role_info != null ? $admin_role_info->name : "",
            'role_id'=>$admin_role_info != null ? $admin_role_info->id : "",
        ];
        return $res_data;
    }

    public function getAdminInfo(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'admin_id'=>'required|exists:admins,id,deleted_at,NULL',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $admin_id = $request->input('admin_id');
        $res_data = self::getAdminData($admin_id);

        return $this->echoSuccessJson('获取管理员信息成功!',$res_data);
    }

    public function editAdmin(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'admin_id'=>'required|exists:admins,id,deleted_at,NULL',
            'admin_name'=>'nullable',
            'password'=>'nullable',
            'role_id'=>'required|exists:roles,id'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $admin_id = $request->input('admin_id');
        $admin_name = $request->input('admin_name',null);
        $password = $request->input('password',null);
        $role_id = $request->input('role_id');

        $admin_obj = Admin::find($admin_id);
        if($password != null){
            $admin_obj->password = bcrypt($password);
        }

        if($admin_name != null){
            $admin_obj->name = $admin_name;
        }

        $admin_obj->save();
        $adminRole  = Role::where('id',$role_id)->get();
        $admin_obj->detachRoles();
        $admin_obj->attachRoles($adminRole);
        $res_data = self::getAdminData($admin_id);

        return $this->echoSuccessJson('编辑管理员成功!',$res_data);

    }

    public function deleteAdmin(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'admin_id'=>'required|exists:admins,id,deleted_at,NULL',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $admin_id = $request->input('admin_id');

        $admin_obj = Admin::find($admin_id);

        $admin_obj->detachRoles();

        $admin_obj->delete();

        return $this->echoSuccessJson('删除管理员成功!');

    }

}