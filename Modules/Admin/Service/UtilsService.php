<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Admin\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Modules\Admin\Entities\AdminLog;
use Modules\Admin\Entities\PermissionRole;
use Modules\Admin\Entities\Role;
use Modules\Admin\Entities\UserLog;
use Modules\Admin\Entities\Permission;

class UtilsService
{
    const ADMIN_LOG_TYPE = [];
    const ADMIN_LOG_ACTION = [];

    const USER_LOG_TYPE = [];
    const USER_LOG_ACTION = [];

    public static function Captcha(){
        return app('captcha')->create('default', true);
    }

    public static function WriteLog($table,$type,$action,$user_or_admin_id,$type_for_id){
        try{
            $ip  = Request::ip();
            if($table == 'admin'){
                AdminLog::create(
                  [
                      'type'=>$type,
                      'action'=>$action,
                      'ip'=>$ip,
                      'admin_id'=>$user_or_admin_id,
                      'type_for_id'=>$type_for_id,
                  ]
                );
            }elseif ($table == 'user'){
                UserLog::create(
                    [
                        'type'=>$type,
                        'action'=>$action,
                        'ip'=>$ip,
                        'user_id'=>$user_or_admin_id,
                        'type_for_id'=>$type_for_id,
                    ]
                );
            }
        }catch (\Exception $e){
            dd($e->getMessage()); //todo 生产环境关闭
            Log::error('Log Table is Error! Message:'.$e->getMessage());
        }
    }

    public static function CreateCheckPermissions($display_name = '',$description = ''){
        $router_name = request()->route()->getName();
        if(!Permission::where('name',$router_name)->exists()) {
            $permission = new Permission();
            $permission->name = $router_name;
            $permission->display_name = $display_name; // optional
            $permission->description = $description; // optional
            $permission->save();
        }

        if(get_class(Auth::user()) == "Modules\Mall\Entities\User"){
            return [false,'非法访问'];
        }

        $admin_name = Auth::user()->name;

        if($admin_name != 'admin'){
            $role_id = DB::table('role_user')->where('user_id',Auth::id())->get()->first()->role_id;
            if($role_id == null){
                return [false,'你的账户没有设定角色,不能访问这个接口!'];
            }

            $permission_id_list = PermissionRole::where('role_id',$role_id)->pluck('permission_id')->toArray();
            $has_permission_name_arr = Permission::whereIn('id',$permission_id_list)->pluck('name')->toArray();
            if(!in_array($router_name,$has_permission_name_arr)){
                return [false,'你没有权限访问这个接口!请联系管理员!'];
            }
        }

        return [true,'ok'];
    }


}