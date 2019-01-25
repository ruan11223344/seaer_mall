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
use App\Utils\Oss;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\UsersExtends;

class UtilsController extends Controller
{
    const OSS_FILE_PATH = 'mall';

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

    public static function uploadMultipleFile($files,$to_path,$return_name = false){
            $file_url_list = [];
            $oss = Oss::getInstance();
            foreach ($files  as $value){
                if (!$value->isValid()) {
                    continue;
                }
                $titles = $value->getClientOriginalExtension();
                // 获取图片在临时文件中的地址
                $pic_path = $value->getRealPath();
                // 制作文件名
                $key = time() . rand(10000, 99999999) . '.'.$titles;
                //阿里 OSS 图片上传
                $result = $oss->put($to_path.$key, file_get_contents($pic_path));

                if (!$result) continue;
                if($return_name){
                    array_push($file_url_list,[$value->getClientOriginalName()=>$oss->url($to_path.$key)]);
                }else{
                    array_push($file_url_list,$oss->url($to_path.$key));
                }
            }
            return $file_url_list;
        }

    public static function uploadFile($file,$to_path,$return_name = false){
            if (!$file->isValid()) {
                return false;
            }
            $titles = $file->getClientOriginalExtension();
            // 获取图片在临时文件中的地址
            $pic_path = $file->getRealPath();
            // 制作文件名
            $key = time() . rand(10000, 99999999) . '.'.$titles;
            //阿里 OSS 图片上传
            $oss = Oss::getInstance();
            $result = $oss->put($to_path.$key, file_get_contents($pic_path));

            if (!$result){
                return false;
            }
            if($return_name){
               return [$file->getClientOriginalName()=>$oss->url($to_path.$key)]
            }else{
                return $oss->url($to_path.$key);
            }
    }

    public static function getAfId(){
        return Auth::user()->usersExtends->af_id;
    }

    public static function getUserAttachmentDirectory(){
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH.'/users/'.$af_id.'/attachment/';
    }

    public static function getUserProductDirectory(){
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH.'/users/'.$af_id.'/product/';
    }

    public static function getUserPrivateDirectory($af_id){
        return self::OSS_FILE_PATH.'/users/'.$af_id.'/private/';
    }

    public static function getUserIdFormAfId($af_id){
        $user_ex = UsersExtends::where('af_id',$af_id)->first();
        if($user_ex != null){
            return $user_ex->user_id;
        }
        return null;
    }

}