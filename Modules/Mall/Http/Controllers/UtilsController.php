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
use Modules\Admin\Entities\Article;
use Modules\Admin\Http\Controllers\ArticleController;
use Modules\Admin\Http\Controllers\FeedbackController;
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

    public function sendFeedback(Request $request){
        $data      = $request->all();
        $validator = Validator::make($data, [
            'message' => 'required',
            'contact_way' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $message = $request->input('message');
        $contact_way = $request->input('contact_way');
        $res = FeedbackController::userPubFeedback($message,Auth::id(),$contact_way);
        if($res){
            return $this->echoSuccessJson('发送反馈成功!');
        }else{
            return $this->echoErrorJson('发送反馈失败!');
        }
    }

    public static function getPublicDirectory()
    {
        return self::OSS_FILE_PATH . '/public/';
    }

    public static function getOneArticleData($article_orm,$get = false){
            if($get){
                $article_orm = $article_orm->get()->first();
            }
            $tmp = [];
            $tmp['article_id'] = $article_orm->id;
            $tmp['article_title'] = $article_orm->title;
            $tmp['publish_time'] = Carbon::parse($article_orm->created_at)->format('Y-m-d H:i:s');
            $tmp['article_type'] = $article_orm->type;
            $tmp['content'] = $article_orm->content;
            $tmp['author'] = $article_orm->author;
            return $tmp;
    }

    public function getUserAgreement(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'agreement_type' => 'required|in:buyers,merchants',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $agreement_type = $request->input('agreement_type');

        $agreement_orm = Article::where('type',$agreement_type == "buyers" ? "buyers_register_agreement" : "merchants_register_agreement")->orderBy('created_at','desc')->take(1);

        $res_data = self::getOneArticleData($agreement_orm,true);
        return $this->echoSuccessJson('获取用户协议成功!',$res_data);
    }

    public function getTitleArticle(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|in:About Afriby.com,Help Center,Service,Finding And Contacting,Novice Guide,Register As a Merchant
,Rule Center,Service Account Center,All Categories',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!' . $validator->messages());
        }

        $title = $request->input('title');

        $article_orm = Article::where('title',$title);
        $article_orm_clone = clone $article_orm;
        if(!$article_orm_clone->exists()){
            return $this->echoErrorJson('该文章不存在,请创建这个标题的文章!');
        }
        $res_data = self::getOneArticleData($article_orm,true);
        return $this->echoSuccessJson('获取文章成功!',$res_data);
    }



    public function getMallNoticeList(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $page = $request->input('page',1);
        $size = $request->input('size',20);

        $article_orm = Article::where('type','system_announcement')->orderBy('created_at','desc');
        $res_data = ArticleController::getArticleData($article_orm,$page,$size);
        return $this->echoSuccessJson('获取系统通知列表成功!',$res_data);
    }

    public function getArticleDetail(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'article_id'=>'required|exists:article,id',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $article_id = $request->input('article_id');
        $article_orm = Article::find($article_id);

        $res_data = self::getOneArticleData($article_orm);

        return $this->echoSuccessJson('成功!',$res_data);
    }


}
