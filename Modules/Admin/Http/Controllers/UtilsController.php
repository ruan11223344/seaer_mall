<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
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
        $data      = $request->all();
        $validator = Validator::make($data, [
            'img' => 'max:2048|image',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $pic   = $request->file('img');
        $res   = \Modules\Mall\Http\Controllers\UtilsController::uploadFile($pic, \Modules\Mall\Http\Controllers\UtilsController::getPublicDirectory(), true);
        return $this->echoSuccessJson('Upload img successfully', $res);
    }
}