<?php

namespace Modules\Admin\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Admin\Entities\Ad;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\EchoJson;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class AdManagerController extends Controller
{
    use EchoJson;
    public function getAdList(Request $request){
        Ad::get()->map(function ($v,$k){
           dd($v);
        });
    }

    public function editAd(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'ad_id'=>'required|exists:ad,id',
            'ad_name'=>'required',
            'jump_url'=>'nullable',
            'image_path'=>'required',
            'enabled'=>'boolean|required',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $ad = Ad::find($request->input('ad_id'));

        if($ad == null){
            return $this->echoErrorJson('这条广告记录不存在!');
        }


        $jump_url = $request->input('jump_url',null);
        if($jump_url == null && isset($data['jump_url'])){
            unset($data['jump_url']);
        }

        $res = $ad->update($data);

        if($res){
            return $this->echoSuccessJson('编辑更新成功!');
        }else{
            return $this->echoErrorJson('编辑更新失败!');
        }



    }
}