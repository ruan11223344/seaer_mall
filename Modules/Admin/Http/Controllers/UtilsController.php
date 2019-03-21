<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\AdminImage;
use Modules\Admin\Service\UtilsService;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UtilsController extends Controller
{
    use EchoJson;

    public function getCaptcha(){
        $captcha = UtilsService::Captcha();
        return $this->echoSuccessJson('获取验证码成功!',$captcha);
    }

    public function uploadImg(Request $request){
        $CheckPermissions = UtilsService::CreateCheckPermissions('通用上传图片','是否能够上传图片');
        if($CheckPermissions[0] == false){
            return $this->echoErrorJson($CheckPermissions[1]);
        }
        $data      = $request->all();
        $validator = Validator::make($data, [
            'img' => 'max:2048|image',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $admin_id = Auth::id();


        $pic   = $request->file('img');
        $res   = \Modules\Mall\Http\Controllers\UtilsController::uploadFile($pic, \Modules\Mall\Http\Controllers\UtilsController::getPublicDirectory(), true);

        $admin_image = AdminImage::create(
            [
                'admin_id'=>$admin_id,
                'image_path'=>$res['path'],
            ]
        ); //记录上传

        UtilsService::WriteLog('admin','upload','img',$admin_id,$admin_image->id);

        return $this->echoSuccessJson('Upload img successfully', $res);


    }
}