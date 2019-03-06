<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Admin\Service\UtilsService;
use Modules\Mall\Entities\User;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class UserManagerController extends Controller
{
    use EchoJson;
    public function getUserList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'nullable',
            'size'=>'nullable',
        ]);

        $page = $request->input('page',1);
        $size = $request->input('size',20);


        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        UtilsService::CreatePermissions('访问活用列表','访问afriby非商家的用户列表');
        $user = new User();

        $user_data_list = [];
        $user_list = $user->offset(($page-1)*$size)->limit($size)->get()->map(function ($v,$k)use(&$user_data_list,$page,$size){
            $tmp = [];
            $userEx = $v->usersExtends;
            $tmp['num'] = $k+1+(($page-1)*$size);//序号
            $tmp['register_time'] = Carbon::parse($v->created_at)->format('Y-m-d');//序号
            $tmp['af_id'] = $userEx->af_id;//序号
            $tmp['member_id'] = $v->name;//序号
            $tmp['email'] = $v->email;//序号
            $tmp['contact_full_name'] = $userEx->contact_full_name;//序号
            $tmp['sex'] = $userEx->sex;//序号
            $tmp['phone_num'] = $userEx->mobile_phone;//序号
            $tmp['address'] = $userEx->detailed_address;//序号
            $tmp['last_login'] = $userEx->detailed_address;//序号
            dd($tmp);

        });
        $count = $user->count();

        $res_data = [];
        $res_data['data'] = $user_list;
        $res_data['size'] = $size;
        $res_data['cur_page'] =$page;
        $res_data['total_page'] = (int)ceil($count/$size);
        $res_data['total_size'] = $count;

        dd($res_data);
    }

    public function getMerchantsList(Request $request){

    }

    public function getAdminList(Request $request){

    }

}