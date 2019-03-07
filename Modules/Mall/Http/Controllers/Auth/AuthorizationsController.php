<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/10
 * Time: 4:49 PM
 */

namespace Modules\Mall\Http\Controllers\Auth;

use Lcobucci\JWT\Parser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Khsing\World\Models\City;
use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use Modules\Admin\Service\UtilsService;
use Modules\Mall\Entities\BusinessRange;
use Modules\Mall\Entities\BusinessType;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\User;
use Modules\Mall\Entities\UsersExtends;
use Modules\Mall\Http\Controllers\MessagesController;
use Modules\Mall\Http\Controllers\Shop\ProductsController;
use Modules\Mall\Http\Controllers\Shop\ProductsGroupsController;
use Modules\Mall\Http\Controllers\Shop\ShopController;
use Modules\Mall\Http\Controllers\UtilsController;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\AuthorizationServer;
use Illuminate\Support\Facades\Auth;
use App\Utils\EchoJson;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    const LOGIN_FAIL_MAX = 5;
    public $username = null;
    protected $maxAttempts = 2;

    use EchoJson,ThrottlesLogins;


    public function username()
    {
        return $this->username;
    }

    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    protected function throttleKey()
    {
        return Str::lower($this->username.'|'.$this->ip);
    }

    protected function incrementLoginAttempts()
    {
        $this->limiter()->hit(
            $this->throttleKey($this->username,$this->ip), $this->decayMinutes()
        );
    }

    protected function clearLoginAttempts()
    {
        $this->limiter()->clear($this->throttleKey());
    }

    protected function hasTooManyLoginAttempts()
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey(), $this->maxAttempts(), $this->decayMinutes()
        );
    }



    public function getAccessToken(AuthorizationServer $server, ServerRequestInterface $serverRequest)
    {
        $data = $serverRequest->getParsedBody();
        $refresh_token = $data['grant_type'] == 'refresh_token' ? true : false;

        if($data === []){
            return $this->echoErrorJson('Error!Parameter cannot be empty!',[]);
        }
        $this->ip = $serverRequest->getServerParams()['REMOTE_ADDR'];
        if($refresh_token == false){
            $this->username =  $data['username'];
        }


        if($this->hasTooManyLoginAttempts()){
            $validator = Validator::make($data, [
                'key' => 'required',
                'captcha' => 'required|captcha_api:' . $data['key'],
            ]);

            if ($validator->fails()) {
                return $this->echoErrorJson('Verification code verification failed!'.$validator->messages());
            }
        }


        try {
            $token_data = json_decode((string)$server->respondToAccessTokenRequest($serverRequest, new Psr7Response)->withStatus(201)->getBody());
            $data = [
                'token_type'=>$token_data->token_type,
                'expires_in'=>$token_data->expires_in,
                'access_token'=>$token_data->access_token,
                'refresh_token'=>$token_data->refresh_token,
            ];
            if($refresh_token == false){
                $this->clearLoginAttempts();
                $user = User::where('name',$this->username)->orWhere('email',$this->username)->get()->first();
                if($user != null){
                    UtilsService::WriteLog('user','auth','login',$user->id,$user->id);
                }
            }


            return $this->echoSuccessJson('Success!',$data);
        } catch (OAuthServerException $e) {
            if($refresh_token == false){
                $this->incrementLoginAttempts();
            }
            return $this->echoErrorJson($e->getMessage());
        }
    }

    public function getUserInfo()
    {
        $user_obj = Auth::user();
        $user = $user_obj->toArray();
        $company = $user_obj->company->toArray();
        $user_extends = $user_obj->usersExtends->toArray();
        $publish_product = [];
        $publishProductPermissions = ProductsController::getPublishProductPermissions();
        $publish_product['status'] = $publishProductPermissions[0];
        $publish_product['message'] = $publishProductPermissions[1];
        $user_extends['avatar_url'] = UtilsController::getPathFileUrl($user_extends['avatar_url']);
        return $this->echoSuccessJson('User information obtained successfully！',compact('user','company','user_extends','publish_product'));
    }


    public function uploadAvatarImg(Request $request){
        $data = $request->all();

        Validator::extend('avatar_base64_check', function($attribute, $value, $parameters)
        {
            try{
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            }catch (Exception $e){
                return false;
            }
        });

        $validator = Validator::make($data, [
            'avatar_img_base64'=>'required|avatar_base64_check',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $img = UtilsController::uploadAvatar($request->input('avatar_img_base64'));
        $img_path = $img['path'];
        $img_url = $img['file_url'];

        $users_extends = Auth::user()->usersExtends;
        $users_extends->update([
           'avatar_url'=>$img_path
        ]);

        return $this->echoSuccessJson('Upload avatar Success!',['avatar_img_path'=>$img_path,'avatar_img_url'=>$img_url]);
    }

    public function getAvatar(){
        $avatar_url = Auth::user()->usersExtends->avatar_url;

        if($avatar_url == null){
            return $this->echoErrorJson('not set an avatar！');
        }else{
            $res = [];
            $res['avatar_url'] = UtilsController::getPathFileUrl($avatar_url);
            $res['avatar_path'] = $avatar_url;

            return $this->echoSuccessJson('Get avatar successfully!',$res);
        }
    }

    public function getAccountInfo(){
        $user_obj = Auth::user();
        $data = [];
        $data['member_id'] = $user_obj->name;
        $data['email_address'] = $user_obj->email;
        $data['contact_full_name'] = $user_obj->usersExtends->contact_full_name;
        $data['mobile_phone'] = $user_obj->usersExtends->mobile_phone;
        $data['country'] =  $user_obj->usersExtends->country_id == MessagesController::KE_COUNTRY_ID ? 'Kenya' : 'China';
        $province = Division::find($user_obj->usersExtends->province_id);
        $city = City::find($user_obj->usersExtends->city_id);
        $data['province/city'] =  $province == null ?  null : $province->name .' '.$city->name;
        $data['address'] = $user_obj->usersExtends->detailed_address;
        $data['sex'] = $user_obj->usersExtends->sex;

        return $this->echoSuccessJson('Obtain account information Success!',$data);
    }

    public function setAccountInfo(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'sex' => 'nullable|in:Mr,Mrs,Miss',
            'contact_full_name' => 'nullable',
            'mobile_phone' => 'nullable',
            'province_id' => 'nullable|exists:world_divisions,id',
            'city_id' => 'nullable|exists:world_cities,id',
            'detailed_address' => 'nullable',
        ]);


        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $usersExtends = Auth::user()->usersExtends;

        $sex =  $request->input('sex',null);
        $contact_full_name =  $request->input('contact_full_name',null);
        $mobile_phone =  $request->input('mobile_phone',null);
        $province_id =  $request->input('province_id',null);
        $city_id =  $request->input('city_id',null);
        $detailed_address =  $request->input('detailed_address',null);

        if($sex !== null){
            $usersExtends->sex = $sex;
        }

        if($contact_full_name !== null){
            $usersExtends->contact_full_name = $contact_full_name;
        }

        if($mobile_phone !== null){
            $usersExtends->mobile_phone = $mobile_phone;
        }

        if($province_id !== null){
            $usersExtends->province_id = $province_id;
        }

        if($city_id !== null){
            $usersExtends->city_id = $city_id;
        }

        if($detailed_address !== null){
            $usersExtends->detailed_address = $detailed_address;
        }

        $res = $usersExtends->save();

        if($res){
            return $this->echoSuccessJson('Update the Success!',Auth::user()->usersExtends->toArray());
        }
    }

    public static function getCompanyInfoData($company_id = null){
        if($company_id == null){
            $company = Auth::user()->company;
        }else{
            $company = Company::find($company_id);
        }

        $data = [];

        if($company == null){
            return $data;
        }else{
            $data['basic_info'] = [];
            $data['business_info'] = [];

            $data['basic_info']['business_type'] = $company->company_business_type_id == null ? null : BusinessType::find($company->company_business_type_id)->name;
            $data['basic_info']['business_type_id'] = $company->company_business_type_id == null ? null : $company->company_business_type_id;
            $data['basic_info']['company_name'] = $company->company_name;
            $data['basic_info']['company_name_in_china'] = $company->company_name_in_china;
            $data['basic_info']['country_id'] = $company->company_country_id;
            $data['basic_info']['country_name'] = Country::find($company->company_country_id) == null ? null : Country::find($company->company_country_id)->name;

            $province = Division::find($company->company_province_id);
            $city = City::find($company->company_city_id);

            $data['basic_info']['province/city'] = $province == null ? null : $province->name.' '.$city->name;
            $data['basic_info']['company_province_id'] = $company->company_province_id;
            $data['basic_info']['company_city_id'] = $company->company_city_id;
            $data['basic_info']['address'] = $company->company_detailed_address;
            $data['basic_info']['telephone'] = $company->company_mobile_phone;
            $data['basic_info']['website'] = $company->company_website;
            $business_range = $company->company_business_range_ids;

            $business_range_str = '';
            if($business_range != null){
                $business_range_arr = explode(',',$business_range);
                BusinessRange::whereIn('id',$business_range_arr)->get()->map(function ($v,$k) use(&$business_range_str){
                    $business_range_str.= ' '.$v->name.'、';
                });
                $business_range_str = mb_substr($business_range_str,0,mb_strlen($business_range_str)-1);
            }else{
                $business_range_arr = [];
            }
            $data['business_info']['business_range'] = $business_range_str;
            $data['business_info']['business_range_id_arr'] = $business_range_arr;

            $main_products = $company->company_main_products;
            $main_products_str = '';
            $main_products_arr = [];
            if($main_products != null){
                $main_products_arr = explode(',',$main_products);
                if(count($main_products_arr) > 1){
                    foreach ($main_products_arr as $v){
                        $main_products_str .= $v .'、';
                    }
                    $main_products_str = mb_substr($main_products_str,0,mb_strlen($main_products_str)-1);
                }
            }

            $data['business_info']['main_products'] = $main_products_str;
            $data['business_info']['main_products_arr'] = $main_products_arr;
            $data['business_info']['company_profile'] = $company->company_profile;
            $data['business_info']['business_license'] = $company->company_business_license;
            $data['business_info']['business_license_path'] = $company->company_business_license_pic_url;
            $data['business_info']['business_license_url'] = UtilsController::getPathFileUrl($company->company_business_license_pic_url);

            $data['other_info'] = [];

            $data['other_info']['business_type_list'] = BusinessRange::all()->toArray();
            $data['other_info']['business_range_list'] = BusinessType::all()->toArray();

            $data['shop_info'] = [];

            $data['shop_info']['slides'] = ShopController::getSlidesData($company_id);
            $data['shop_info']['banner'] = ShopController::getShopBannerData($company_id);
            $userEx = UsersExtends::where('user_id',$company->user_id)->get()->first();
            $userEx_avatar = $userEx->avatar_url;
            $data['shop_info']['avatar_path'] = $userEx_avatar == null ? null : $userEx_avatar ;
            $data['shop_info']['avatar_url'] = $userEx_avatar == null ? null : UtilsController::getPathFileUrl($userEx_avatar);
            $data['shop_info']['af_id'] = $userEx->af_id;
            $shop_group_data = ProductsGroupsController::getProductGroupInfo($company->user_id);

            if(is_array($shop_group_data) && count($shop_group_data) > 0){
                foreach ($shop_group_data as $k=>$v){
                    if($v['show_home_page'] == false){
                        unset($shop_group_data[$k]);
                    }else{
                        if(is_array($v['children']) && count($v['children'] > 0)){
                            foreach ($v['children'] as $kk=>$vv){
                                if($vv['show_home_page'] == false){
                                    unset($v['children'][$kk]);
                                }
                            }
                        }
                    }
                }
            }

            $data['shop_info']['shop_group'] = [];


            foreach ($shop_group_data as $v){
                array_push($data['shop_info']['shop_group'],$v);
            }

            $data['shop_info']['product_recommend'] = ShopController::getRecommendProductData($company_id);

            $last_update_product_obj  = Products::where(
                [
                    ['company_id','=',$company_id],
                    ['product_status','=',ProductsController::PRODUCT_STATUS_SALE],
                    ['product_audit_status','=',ProductsController::PRODUCT_AUDIT_STATUS_SUCCESS],
                ]
            )->limit(8)->orderBy('created_at','desc');
            $product_last_update = ProductsController::getProductFormatInfo($last_update_product_obj);

            $data['shop_info']['product_last_update'] = $product_last_update;


            return $data;
        }
    }

    public function getCompanyInfo(){
        $data = self::getCompanyInfoData();
        return $this->echoSuccessJson('Obtain company information about Success!',$data);
    }

    public function setCompanyInfo(Request $request){
        $data = $request->all();

        Validator::extend('business_type_check', function($attribute, $value,$parameters,$validator){
            if(BusinessType::find($value) == null){
                $validator->setCustomMessages(['business_type_check' => 'business_type id don\'t exists! id:'.$value]);
                return false;
            }
            return true;
        });

        Validator::extend('business_range_arr_check', function($attribute, $value,$parameters,$validator){
            if(!is_array($value)){
                $validator->setCustomMessages(['business_range_arr_check' => 'business_range must be a array']);
                return false;
            }else{
                if(count($value) > 5){
                    $validator->setCustomMessages(['business_range_arr_check' => ' The business_range largest element is 5']);
                    return false;
                }
            }
            foreach ($value as $v){
                if(BusinessRange::find($v) == null){
                    $validator->setCustomMessages(['business_range_arr_check' => 'business_range id don\'t exists id:'.$v]);
                    return false;
                }
            }
            return true;
        });

        Validator::extend('oss_path', function($attribute, $value,$parameters,$validator){
            if($value != null){
                if(stripos($value,UtilsController::getUserPrivateDirectory(Auth::user()->usersExtends->af_id)) === false){
                    $validator->setCustomMessages(['oss_path' => 'oss path error!']);
                    return false;
                }
            }
            return true;
        });


        $validator = Validator::make($data, [
            'company_business_type_id' => 'nullable|business_type_check',
            'company_name' => 'nullable',
            'company_name_in_china' => 'nullable',
            'company_province_id' => 'nullable|exists:world_divisions,id',
            'company_city_id' => 'nullable|exists:world_cities,id',
            'company_detailed_address' => 'nullable',
            'company_mobile_phone' => 'nullable',
            'company_website' => 'nullable|url',
            'company_business_range_ids' => 'nullable|business_range_arr_check',
            'company_main_products' => 'nullable|array|max:5',
            'business_license' => 'nullable',
            'company_business_license_pic_url' => 'nullable|oss_path',
            'company_profile' => 'nullable',
        ]);


        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $company = Auth::user()->company;

        foreach ($data as $k=>$v){
            if(($k == 'company_business_range_ids' && $v != null) || ($k == 'company_main_products' && $v != null)){
                if(is_array($v)){
                    $data[$k] = implode(',',$v);
                }
            }
        }

        if(isset($data['company_business_range_ids']) && is_array($data['company_business_range_ids']) && count($data['company_business_range_ids']) == 0){
            unset($data['company_business_range_ids']);
        }

        if(isset($data['company_main_products']) && is_array($data['company_main_products']) && count($data['company_main_products']) == 0){
            unset($data['company_main_products']);
        }

        if(isset($data['company_business_range_ids']) && $data['company_business_range_ids'] == null){
            unset($data['company_business_range_ids']);
        }

        $res = $company->update($data);

        if($res){
            $data = self::getCompanyInfoData();
            return $this->echoSuccessJson('Setup company information successful!',$data);
        }else{
            return $this->echoErrorJson('Write to database failed!');
        }



    }

    public function logout(Request $request){
        $value = $request->bearerToken();
        if ($value) {
            $id = (new Parser())->parse($value)->getHeader('jti');
            DB::table('oauth_access_tokens')->where('id', '=', $id)->update(['revoked' => 1]);
        }
        return $this->echoSuccessJson('登出成功!');
    }
}