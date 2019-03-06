<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Modules\Admin\Service\UtilsService;
use App\Utils\EchoJson;


class UtilsController extends Controller
{
    use EchoJson;

    public function getCaptcha(){
        $captcha = UtilsService::Captcha();
        return $this->echoSuccessJson('获取验证码成功!',$captcha);
    }
}