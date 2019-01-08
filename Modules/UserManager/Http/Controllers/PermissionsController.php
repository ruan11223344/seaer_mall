<?php

namespace Modules\UserManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PermissionsController extends Controller
{

    /**
     * 检查是否有权限修改权
     * @return Response
     */
    public function __construct()
    {

    }

    /**
     * 创建权限
     * @return Response
     */
    public function createPermissions(Request $request){
        $permission = Permission::create(['name' => 'edit articles']);
    }

    /**
     * 修改权限
     * @return Response
     */
    public function editPermissions(Request $request){
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('users_manage');
    }

    /**
     * 删除权限
     * @return Response
     */
    public function deletePermissions(Request $request){

    }

    /**
     * 获取权限列表
     * @return Response
     */
    public function getPermissionsList(Request $request){

    }
}
