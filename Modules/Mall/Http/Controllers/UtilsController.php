<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Mall\Http\Controllers;
use App\Utils\City;
use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class UtilsController extends Controller
{
    use EchoJson;
    public function getCaptcha(){
        return $this->echoSuccessJson('获取验证码成功!',app('captcha')->create('default', true));
    }

    public function checkCaptchaUrl(Request $request){
        if (!captcha_api_check($request->captcha, $request->key)){
            return $this->echoErrorJson('验证码验证失败!');
        }
        return $this->echoSuccessJson('验证码验证成功!');
    }

    public static function checkCaptcha($captcha,$key){
        if (!captcha_api_check($captcha, $key)){
            return false;
        }else{
            return true;
        }
    }

    public function getProvincesList(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'country_code' => 'required|alpha|size:2|exists:world_countries,code',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $provinces  = City::getProvincesList($data['country_code'])->pluck('id','name');

        $data = [];

        foreach ($provinces as $name=>$id){
            array_push($data,['province_id'=>$id,'name'=>$name]);
        }
        return $this->echoSuccessJson('成功!',$data);
    }

    public function getCityList(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'province_id' => 'required|numeric|exists:world_divisions,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $citys = City::getCityList($data['province_id'])->pluck('id','name');

        $data = [];

        foreach ($citys as $name=>$id){
            array_push($data,['city_id'=>$id,'name'=>$name]);
        }
        return $this->echoSuccessJson('成功!',$data);
    }

}