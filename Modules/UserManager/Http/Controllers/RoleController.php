<?php

namespace Modules\UserManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    /**
     * 创建角色
     * @return Response
     */
    public function createRole(Request $request){
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('users_manage');
    }

    /**
     * 修改角色
     * @return Response
     */
    public function editRole(Request $request){
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('users_manage');
    }

    /**
     * 删除角色
     * @return Response
     */
    public function deleteRole(Request $request){

    }

    /**
     * 获取角色列表
     * @return Response
     */
    public function getRoleList(Request $request){

    }
}
