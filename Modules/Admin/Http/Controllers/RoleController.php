<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\Role;
use App\Utils\EchoJson;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    use EchoJson;

    public function getRoleList(){
        $data_list = [];
        Role::all()->map(function ($v)use(&$data_list){
            $tmp = [];
            $tmp['role_id'] = $v->id;
            $tmp['role_name'] = $v->name;
            $tmp['role_display_name'] = $v->display_name;
            $tmp['description'] = $v->description;
            array_push($data_list,$tmp);
        });
        return $this->echoSuccessJson('获取角色列表成功!',$data_list);
    }

    public function getRolePermissions(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'role_id'=>'required|exists:roles,id',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $role_id = $request->input('role_id');

        $permission_list = PermissionController::getPermissionByRole($role_id);
        return $this->echoSuccessJson('获取角色已有权限列表成功!',$permission_list);
    }

    public function addRole(Request $request){
        $data = $request->all();

        Validator::extend('permissions_list_check', function($attribute, $value,$parameters,$validator){
            if($value == null){
                return true;
            }
            foreach ($value as $v){
                if(Permission::find($v) == null){
                    $validator->setCustomMessages(['permissions_list_check' => 'permissions_id don\'t exists!:permissions id:'.$v]);
                    return false;
                }
            }
            return true;
        }); //检测

        $validator = Validator::make($data,[
            'role_name'=>'required|string',
            'permissions_list'=>'array|permissions_list_check',
            'all_permissions'=>'boolean'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $role_name = $request->input('role_name');
        $permissions_list = $request->input('permissions_list');

        if(Role::where('name',$role_name)->exists()){
            return $this->echoErrorJson('错误!存在同名的权限组!');
        }

        $admin = new Role();
        $admin->name         = $role_name;
        $admin->display_name = $role_name;
        $admin->save();

        $all_permissions = $request->input('all_permissions',false);

        if($all_permissions){
            self::giveAllPermissionsToRole($admin->id);
            return $this->echoSuccessJson('创建权限组成功!',['role_name'=>$admin->name,'role_id'=>$admin->id]);
        }

        $permissions_list_arr = [];
        foreach ($permissions_list as $v){
            $permissions_list_arr[] = Permission::find($v);
        }

        $admin->attachPermissions($permissions_list_arr);


        return $this->echoSuccessJson('创建权限组成功!',['role_name'=>$admin->name,'role_id'=>$admin->id]);
    }

    public static function giveAllPermissionsToRole($role_id){
        $admin = Role::find($role_id);
        $admin->detachPermissions(Permission::all());
        $admin->attachPermissions(Permission::all());
    }

    public function editRole(Request $request){
        $data = $request->all();

        Validator::extend('permissions_list_check', function($attribute, $value,$parameters,$validator){
            if($value == null){
                return true;
            }
            foreach ($value as $v){
                if(Permission::find($v) == null){
                    $validator->setCustomMessages(['permissions_list_check' => 'permissions_id don\'t exists!:permissions id:'.$v]);
                    return false;
                }
            }
            return true;
        });

        $validator = Validator::make($data,[
            'role_name'=>'nullable',
            'role_id'=>'required|exists:roles,id',
            'all_permissions'=>'boolean',
            'permissions_list'=>'array|permissions_list_check'
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $role_id = $request->input('role_id');

        $all_permissions = $request->input('all_permissions',false);
        if($all_permissions){
            self::giveAllPermissionsToRole($role_id);
            return $this->echoSuccessJson('修改权限组成功!');
        }

        $role_name = $request->input('role_name',null);

        $permissions_list = $request->input('permissions_list');

        $permissions_list_arr = [];
        foreach ($permissions_list as $v){
            $permissions_list_arr[] = Permission::find($v);
        }

        $admin = Role::find($role_id);

        if($role_name != null){
            $admin->name = $role_name;
            $admin->save();
        }

        $admin->detachPermissions(Permission::all());
        $admin->attachPermissions($permissions_list_arr);

        $role_permission = PermissionController::getPermissionByRole($role_id);

        return $this->echoSuccessJson('修改权限组成功!',$role_permission);

    }

    public function deleteRole(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'role_id'=>'required|exists:roles,id',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $role_id = $request->input('role_id');

        $role = Role::findOrFail($role_id); // Pull back a given role

        // Regular Delete
        $role->delete(); // This will work no matter what

        // Force Delete
        $role->users()->sync([]); // Delete relationship data
        $role->perms()->sync([]); // Delete relationship data

        $role->forceDelete(); // Now force delete will work regardless of whether the pivot table has cascading delete

        $role_permission = PermissionController::getPermissionByRole($role_id);

        return $this->echoSuccessJson('删除权限组成功!',$role_permission);
    }

}