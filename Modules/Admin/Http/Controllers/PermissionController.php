<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\Role;
use App\Utils\EchoJson;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    use EchoJson;
    public static function getPermissionByRole($role_id){

    }

    public function getPermissionList(){

    }

}