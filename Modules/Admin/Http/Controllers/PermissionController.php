<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\PermissionRole;
use App\Utils\EchoJson;

class PermissionController extends Controller
{
    use EchoJson;
    public static function getPermissionByRole($role_id){
        $permission_id_list = PermissionRole::where('role_id',$role_id)->get()->pluck('permission_id');
        $data = self::getPermissionByIdList($permission_id_list);
        return $data;
    }

    public static function getPermissionByIdList($permission_id_list){
        $data_list = [];
        Permission::whereIn('id',$permission_id_list)->get()->map(function ($v)use(&$data_list){
            $tmp = [];
            $tmp['permission_id'] = $v->id;
            $tmp['permission_name'] = $v->name;
            $tmp['display_name'] = $v->display_name;
            $tmp['description'] = $v->description;
            array_push($data_list,$tmp);
        });
        return $data_list;
    }

}