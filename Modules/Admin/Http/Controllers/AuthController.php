<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\AdminLog;
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\PermissionRole;
use Modules\Admin\Entities\Role;
use Modules\Admin\Service\UtilsService;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class AuthController extends Controller
{
    use EchoJson;

    public function getAccessToken(AuthorizationServer $server, ServerRequestInterface $serverRequest){
        $data = $serverRequest->getParsedBody();
        $refresh_token = $data['grant_type'] == 'refresh_token' ? true : false;
        if($data === []){
            return $this->echoErrorJson('Error!Parameter cannot be empty!',[]);
        }

        if(isset($data['username'])){
            $validator = Validator::make($data, [
                'key' => 'required',
                'captcha' => 'required|captcha_api:' . $data['key'],
            ]);

            if ($validator->fails()) {
                return $this->echoErrorJson('Verification code verification failed!'.$validator->messages());
            }
        }


        try {
            $token_data = json_decode((string)$server->respondToAccessTokenRequest($serverRequest, new Psr7Response)->withStatus(201)->getBody());
            $res_data = [
                'token_type'=>$token_data->token_type,
                'expires_in'=>$token_data->expires_in,
                'access_token'=>$token_data->access_token,
                'refresh_token'=>$token_data->refresh_token,
            ];


            if($refresh_token == false){
                $admin = Admin::where('name',$data['username'])->orWhere('email',$data['username'])->get()->first();
                UtilsService::WriteLog('admin','auth','login',$admin->id,$admin->id);
            }


            return $this->echoSuccessJson('Success!',$res_data);
        } catch (OAuthServerException $e) {
            return $this->echoErrorJson($e->getMessage());
        }
    }

    public function logout(Request $request){
        $value = $request->bearerToken();
        if ($value) {
            $id = (new Parser())->parse($value)->getHeader('jti');
            DB::table('oauth_access_tokens')->where('id', '=', $id)->update(['revoked' => 1]);
        }
        return $this->echoSuccessJson('登出成功!');
    }

    public function addAdmin(Request $request){
        $CheckPermissions = UtilsService::CreateCheckPermissions('添加管理员','管理员是否能够添加新的管理员');
        if($CheckPermissions[0] == false){
            return $this->echoErrorJson($CheckPermissions[1]);
        }

        $data = $request->all();

        $validator = Validator::make($data,[
            'admin_name'=>'required',
            'password'=>'required|confirmed',
            'role_id'=>'required|exists:roles,id'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }



        $name = $request->input('admin_name');

        if(Admin::withTrashed()->where('name',$name)->exists()){
            return $this->echoErrorJson('管理员名已经存在!');
        }

        $password = $request->input('password');
        $role_id = $request->input('role_id');
        $admin = Admin::create(
           [
               'name'=>$name,
               'password'=>bcrypt($password)
           ]
        );

        $adminRole  = Role::where('id',$role_id)->get();
        $admin->attachRoles($adminRole);

        return $this->echoSuccessJson('创建管理员成功!');
    }

    public function getAccountInfo(){
        $admin_info = [];
        $admin_info['name'] = Auth::user()->name;
        $admin_info['id'] = Auth::id();
        $role_id_obj = DB::table('role_user')->where('user_id',Auth::id());
        $role_id_clone = clone $role_id_obj;
        if($role_id_obj->exists()){
            $role_id = $role_id_clone->get()->first()->role_id;
            $role_name = Role::find($role_id)->name;
        }else{
            $role_name = '无权限组';
        }

        $admin_info['role_name'] = $role_name;

        return $this->echoSuccessJson('获取管理员信息成功!',$admin_info);
    }

    public function canAccessRoute(){
        $data = [];
        $data['首页'] = true;
        $data['用户管理'] = [];
        $data['商品管理'] = [];
        $data['文章管理'] = [];
        $data['广告管理'] = [];
        $data['系统公告'] = [];
        $data['意见反馈'] = [];
        $role_id = DB::table('role_user')->where('user_id',Auth::id())->get()->first()->role_id;
        $permission_id_list = PermissionRole::where('role_id',$role_id)->pluck('permission_id');
        $has_permission_name_arr = Permission::whereIn('id',$permission_id_list)->pluck('name')->toArray();
        foreach ($has_permission_name_arr as $v){
            switch ($v){
                case 'admin.user.list':
                    $data['用户管理']['用户'] = true;
                    break;
                case 'admin.user.merchants.list':
                    $data['用户管理']['商家'] = true;
                    break;
                case 'admin.user.admin.list':
                    $data['用户管理']['管理员'] = true;
                    break;
                case 'admin.product.list':
                    $data['商品管理']['全部商品'] = true;
                    break;
                case 'admin.product.auditList':
                    $data['商品管理']['待审核商品'] = true;
                    break;
                case 'admin.article.SystemArticleList':
                    $data['文章管理']['系统文章'] = true;
                    break;
                case 'admin.article.AgreementsList':
                    $data['文章管理']['会员协议'] = true;
                    break;
                case 'admin.ad.list':
                    $data['广告管理']['首页广告'] = true;
                    break;
                case 'admin.article.SystemAnnouncementList':
                    $data['系统公告']['系统公告'] = true;
                    break;
                case 'admin.feedback.list':
                    $data['意见反馈']['反馈信息'] = true;
                    break;
            }
        }

        foreach ($data as $k=>$v){
            if(is_array($v) && count($v) == 0){
                unset($data[$k]);
            }
        }
        return $this->echoSuccessJson('获取可访问路由成功!',$data);
    }
}