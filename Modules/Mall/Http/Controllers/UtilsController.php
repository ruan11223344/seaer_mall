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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Modules\Mall\Entities\UsersExtends;
use Swap\Laravel\Facades\Swap;

class UtilsController extends Controller
{
    const OSS_FILE_PATH = 'mall';

    use EchoJson;

    public function getCaptcha()
    {
        return $this->echoSuccessJson('The verification code was successfully obtained!', app('captcha')->create('default', true));
    }

    public function checkCaptchaUrl(Request $request)
    {
        if (!captcha_api_check($request->captcha, $request->key)) {
            return $this->echoErrorJson('Verification code verification failed!');
        }
        return $this->echoSuccessJson('Verification code verified successfully!');
    }

    public static function checkCaptcha($captcha, $key)
    {
        if (!captcha_api_check($captcha, $key)) {
            return false;
        } else {
            return true;
        }
    }

    public function getProvincesList(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'country_code' => 'required|alpha|size:2|exists:world_countries,code',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $provinces = City::getProvincesList($data['country_code'])->pluck('id', 'name');

        $data = [];

        foreach ($provinces as $name => $id) {
            array_push($data, ['province_id' => $id, 'name' => $name]);
        }
        return $this->echoSuccessJson('Success!', $data);
    }

    public function getCityList(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'province_id' => 'required|numeric|exists:world_divisions,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $citys = City::getCityList($data['province_id'])->pluck('id', 'name');

        $data = [];

        foreach ($citys as $name => $id) {
            array_push($data, ['city_id' => $id, 'name' => $name]);
        }
        return $this->echoSuccessJson('Success!', $data);
    }

    public static function uploadMultipleFile($files, $to_path, $return_name = false, $return_path = false)
    {
        $file_url_list  = [];
        $file_path_list = [];
        $oss            = Oss::getInstance();
        foreach ($files as $value) {
            if (!$value->isValid()) {
                continue;
            }
            $titles = $value->getClientOriginalExtension();
            // 获取图片在临时文件中的地址
            $pic_path = $value->getRealPath();
            // 制作文件名
            $key = time() . rand(10000, 99999999) . '.' . $titles;
            //阿里 OSS 图片上传
            $result = $oss->put($to_path . $key, file_get_contents($pic_path));

            if (!$result) {
                continue;
            }
            if ($return_name) {
                array_push($file_url_list, ['name' => $value->getClientOriginalName(), 'url' => $oss->url($to_path . $key), 'path' => $to_path . $key]);
            } else {
                array_push($file_url_list, $oss->url($to_path . $key));
            }

            if ($return_path) {
                array_push($file_path_list, $to_path . $key);
            }
        }

        if ($return_path) {
            return $file_path_list;
        }

        return $file_url_list;
    }

    public static function uploadFile($file, $to_path, $return_name = false)
    {
        if (!$file->isValid()) {
            return false;
        }
        $titles = $file->getClientOriginalExtension();
        // 获取图片在临时文件中的地址
        $pic_path = $file->getRealPath();
        // 制作文件名
        $key = time() . rand(10000, 99999999) . '.' . $titles;
        //阿里 OSS 图片上传
        $oss    = Oss::getInstance();
        $result = $oss->put($to_path . $key, file_get_contents($pic_path));

        if (!$result) {
            return false;
        }

        if ($return_name) {
            return ['name' => $file->getClientOriginalName(), 'url' => $oss->url($to_path . $key), 'path' => $to_path . $key];
        } else {
            return $to_path . $key;
        }
    }

    public static function getBase64ImgTypeBinary($base64)
    {
        $img_data    = explode(',', $base64);
        $file_type   = explode(';', explode('/', $img_data[0])[1])[0];
        $file_binary = base64_decode($img_data[1]);

        return compact('file_type', 'file_binary');
    }

    public static function uploadFilesByBase64($base64_arr)
    {
        $file_url_list = [];
        $to_path       = self::getUserShopDirectory();
        if (is_array($base64_arr)) {
            $oss = Oss::getInstance();
            foreach ($base64_arr as $v) {
                $type_binary = self::getBase64ImgTypeBinary($v);
                $key         = time() . rand(10000, 99999999) . '.' . $type_binary['file_type'];
                $oss->put($to_path . $key, $type_binary['file_binary']);
                array_push($file_url_list, ['file_url' => $oss->url($to_path . $key), 'path' => $to_path . $key]);
            }

            return $file_url_list;
        }
    }

    public static function uploadAvatar($base64)
    {
        $to_path     = self::getAvatarDirectory();
        $oss         = Oss::getInstance();
        $type_binary = self::getBase64ImgTypeBinary($base64);
        $key         = time() . rand(10000, 99999999) . '.' . $type_binary['file_type'];
        $oss->put($to_path . $key, $type_binary['file_binary']);
        return ['file_url' => $oss->url($to_path . $key), 'path' => $to_path . $key];
    }

    public static function getAfId()
    {
        return Auth::user()->usersExtends->af_id;
    }

    public static function getUserAttachmentDirectory()
    {
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH . '/users/' . $af_id . '/attachment/';
    }

    public static function getUserProductDirectory()
    {
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH . '/users/' . $af_id . '/product/';
    }

    public static function getUserAlbumDirectory()
    {
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH . '/users/' . $af_id . '/album/';
    }

    public static function getUserPrivateDirectory($af_id)
    {
        return self::OSS_FILE_PATH . '/users/' . $af_id . '/private/';
    }

    public static function getUserProtectedDirectory()
    {
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH . '/users/' . $af_id . '/private/';
    }

    public static function getUserShopDirectory()
    {
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH . '/users/' . $af_id . '/shop/';
    }

    public static function getAvatarDirectory()
    {
        $af_id = self::getAfId();
        return self::OSS_FILE_PATH . '/users/' . $af_id . '/avatar/';
    }

    public static function getUserIdFormAfId($af_id)
    {
        $user_ex = UsersExtends::where('af_id', $af_id)->first();
        if ($user_ex != null) {
            return $user_ex->user_id;
        }
        return null;
    }

    public static function getPathFileUrl($path)
    {
        if ($path == null) {
            return null;
        }
        return env('OSS_URL') . $path;
    }

    public static function getBaseCurrencyConverter()
    {
        $time_key = Carbon::now()->format('Y-m-d');
        if (Cache::has($time_key)) {
            $rmb_ksh = Cache::get($time_key);
        } else {
            $rate_kes  = Swap::latest('EUR/KES')->getValue();
            $rate_cny  = Swap::latest('EUR/CNY')->getValue();
            $rmb_ksh   = $rate_kes / $rate_cny;
            $expiresAt = Carbon::now()->addHour(4);
            Cache::put($time_key, $rmb_ksh, $expiresAt);
        }
        return $rmb_ksh;
    }

    public function currencyConverter(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'from'   => 'in:KES,CNY',
            'to'     => 'in:CNY,KES',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $from   = $request->input('from');
        $to     = $request->input('to');
        $amount = $request->input('amount');

        if ($from == $to) {
            return $this->echoErrorJson('Error!Conversion currency cannot be the same!');
        }

        $rmb_ksh = self::getBaseCurrencyConverter();

        if ($from == 'KES') {
            $res = $amount / $rmb_ksh;
        } elseif ($from == 'CNY') {
            $res = $amount * $rmb_ksh;
        }

        $res = round($res, 2);

        return $this->echoSuccessJson('Conversion Success!', ['form' => $from, 'to' => $to, 'amount' => $amount, 'conversion' => $res]);

    }

    public function uploadBusinessLicense(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'business_license_img' => 'max:2048|image',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $pic   = $request->file('business_license_img');
        $af_id = self::getAfId();
        $res   = self::uploadFile($pic, UtilsController::getUserPrivateDirectory($af_id), true);
        return $this->echoSuccessJson('Upload business license successfully', $res);
    }

    public static function getMallNotice(Request $request)
    {
        //todo 获取个人中心页面的新闻。 等待后台建表后完成此方法
    }
}
