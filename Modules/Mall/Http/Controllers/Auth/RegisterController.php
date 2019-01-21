<?php

namespace Modules\Mall\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Utils\EMail;
use App\Utils\Oss;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Utils\EchoJson;
use Khsing\World\Models\Country;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\RegisterTemp;
use Modules\Mall\Entities\UsersExtends;
use Modules\Mall\Entities\User;
use Modules\Mall\Http\Controllers\UtilsController;
use Webpatser\Uuid\Uuid;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class RegisterController extends Controller
{
    const SEND_EMAIL_MAX = 20;  //相同邮箱24内最多发送6封注册邮件

    use EchoJson,AuthenticatesUsers;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function register(Request $request)
    {
        $data = $request->all();
        if(Auth::check()){
            return $this->echoJson('您已经登录,无法进行注册!',400);
        }

        Validator::extend('check_china', function($attribute, $value){
            if($attribute == 'china_business_license'){
                if($value !== null){
                    if(preg_match("/(^(?:(?![IOZSV])[\dA-Z]){2}\d{6}(?:(?![IOZSV])[\dA-Z]){10}$)|(^\d{15}$)/", $value)){
                        return true;
                    }else{
                        return false;
                    }
                }
            }elseif ($attribute == 'company_name_in_china'){
                if($value !== null){
                    if(preg_match("/[\x{4e00}-\x{9fa5}]{2,50}/u", $value)){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
            return true;
        }); //检测

        $validator = Validator::make($data, [
            'password' =>  [
                'required',
                'confirmed',  //password_confirmation 字段必须存在
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,20}$/',
                'between:6,20'
            ],
            'account_type' =>'in:0,1,2|required',
            'sex'=>'in:Miss,Mr,Mrs|required',
            'company_name' => 'required_if:account_type,0|required_if:account_type,1|string|between:2,50',
            'company_name_in_china'=>[
                'check_china'
            ],
            'china_business_license'=>[
                'check_china'
            ],
            'business_license_img'=>'max:1024|nullable',
            'contact_full_name'=>'string|required|between:2,30',
            'mobile_phone'=>'required|phone:CN,KE',
            'province_id'=>'required|exists:world_divisions,id',
            'city_id'=>'required|exists:world_cities,id',
            'uuid'=>[
                Rule::exists('register_temp','register_uuid')->where(function ($query) {
                    $query->where(
                        [
                            ['created_at','>',Carbon::now()->parse("24 hours ago")->toDateTimeString()],
                            ['status','=',RegisterTemp::STATUS_VISITED]
                        ]
                    );
                })
            ],
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        try{
            $account_type = $request->input('account_type');
            $uuid = $request->input('uuid');

            $company_business_license_pic_url = null;
            if($account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA){
                $pic = $request->file('business_license_img');
                $af_id = $this->getAfId($uuid,$account_type);
                $res = UtilsController::uploadFile($pic,UtilsController::getUserPrivateDirectory($af_id));
                $company_business_license_pic_url = !$res ?  null : $res;
            }

            $reg_temp = RegisterTemp::where('register_uuid',$uuid)->first();
            $request->merge(['name' => $reg_temp->name]);
            $request->merge(['email' => $reg_temp->email]);

            DB::beginTransaction();
            event(new Registered($user = $this->create($request->all())));

            if(in_array((integer)$request->input('account_type'),
                [
                    UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA,
                    UsersExtends::ACCOUNT_TYPE_COMPANY_KENYA
                ]

            )){
              $company = Company::create(
                  [
                      'user_id'=>$user->id,
                      'company_name'=>$request->input('company_name'),
                      'company_name_in_china'=>$request->input('company_name_in_china',null),
                      'company_business_license'=>$request->input('china_business_license'),
                      'company_business_license_pic_url'=>$company_business_license_pic_url,
                  ]
                );

              $country_id = $account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA ? Country::getByCode('cn')->id : Country::getByCode('ke')->id;

              $user_extends = UsersExtends::create(
                  [
                        'user_id'=>$user->id,
                        'af_id'=>$af_id,
                        'company_id'=>$company->id,
                        'account_type'=>$account_type,
                        'country_id'=>$country_id,
                        'province_id'=>$request->input('province_id'),
                        'city_id'=>$request->input('city_id'),
                        'mobile_phone'=>$request->input('mobile_phone'),
                        'sex'=>$request->input('sex'),
                        'contact_full_name'=>$request->input('contact_full_name'),
                        'chinese_name'=>$request->input('chinese_name',null),
                    ]
                );
            }
            // RegisterTemp::where('register_uuid',$uuid)->update(['status'=>RegisterTemp::STATUS_SUCCESS]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->echoErrorJson('注册失败',[$e->getMessage()]);
        }
        $this->guard()->login($user);

        $token = $user->createToken(null)->accessToken;

        return $this->echoSuccessJson('注册成功!',['access_token'=>$token,'user_info'=>[
            'user'=>$user,
            'user_extends'=>$user_extends,
            'company'=>$company
        ]]);

    }

    public function checkRegisterStatus(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'uuid'=>[
                Rule::exists('register_temp','register_uuid')->where(function ($query) {
                    $query->where(
                        [
                            ['created_at','>',Carbon::now()->parse("24 hours ago")->toDateTimeString()],
                            ['status','=',RegisterTemp::STATUS_WAITING]
                        ]
                    );
                })
            ],
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('this page is expired!'.$validator->messages());
        }else{
            $reg_tmp = RegisterTemp::where('register_uuid',$data['uuid'])->first();
            $reg_tmp->update(['status' => RegisterTemp::STATUS_VISITED]);
            return $this->echoSuccessJson('you can continue to register!',[
                'account_type'=>$reg_tmp->account_type,
                'member_id'=>$reg_tmp->member_id,
                'email'=>$reg_tmp->email,
            ]);
        }
    }

    public function sendRegisterEmail(Request $request){
        $data = $request->all();
        $messages = [
            'member_id.required'=>'please input member_id',
            'captcha.required' => 'please input captcha',
            'captcha.captcha_api' => 'captcha error,please retry!',
            'i_agree' => 'you must be agree agreenment!',
            'email.check_day_email'=>'Only '.self::SEND_EMAIL_MAX.' emails can be sent within 24 hours.'
        ];

        Validator::extend('check_day_email', function($attribute, $value){
            $count = RegisterTemp::where([
                ['created_at','>',Carbon::now()->parse("24 hours ago")->toDateTimeString()],
                ['email','=',$value],
            ])->count();
            if($count >= self::SEND_EMAIL_MAX){
                return false;
            }else{
                return true;
            }
        }); //检测

        $validator = Validator::make($data, [
            'member_id'=>[
                'required',
                'string',
                'between:6,20',
                'alpha_dash',
                'unique:users,name',
                Rule::unique('register_temp','name')->where(function ($query) {
                $query->where(
                    [
                        ['created_at','>',Carbon::now()->parse("24 hours ago")->toDateTimeString()],
                        ['status','=',RegisterTemp::STATUS_WAITING]
                    ]
                );
                }),
            ],
//            'key' => 'required',
//            'captcha' => 'required|captcha_api:' . $request->input('key'),
            'email' => 'email|required|unique:users,email|check_day_email',
            'account_type' =>'in:0,1,2|required',
            'i_agree'=>'required|accepted'
        ],$messages);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $register_uuid = Uuid::generate();
        $email = $data['email'];
        try{
            DB::beginTransaction();
            RegisterTemp::create([
                'email'=>$data['email'],
                'name'=>$data['member_id'],
                'account_type'=>$data['account_type'],
                'status'=>RegisterTemp::STATUS_WAITING,
                'register_uuid'=>$register_uuid,
            ]);
            $email_obj = new EMail();
            $subject = 'Please verify your email address to finish your account registration';
            if($email_obj->send(
                $email,$subject,[
                    'register_url'=>$this->getRegisterUrl($data['account_type'],$register_uuid),
                    'logo_url'=>asset('/img/logo.png'),
                ],$email_obj::TEMPLATE_REGISTER)
            ){
                DB::commit();
                return $this->echoSuccessJson('邮件发送成功!',['redirect_to'=>EMail::foundEmailUrl($email)]);
            }else{
                DB::rollback();
                return $this->echoErrorJson('注册邮件发送失败!请联系管理员!');
            }
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('提交失败',[$e->getMessage()]);
        }
    }

    public function getRegisterUrl($account_type,$register_uuid){
        $str = 'http://'.env('MALL_DOMAIN').'/registered/three?';
        if(in_array($account_type,[UsersExtends::ACCOUNT_TYPE_COMPANY_KENYA,UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA])){
            $u_type = 'company';
        }else{
            $u_type = 'buyer';
        }

        $str .= 'u_type='.$u_type;

        if($account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_KENYA){
            $u_from = 'KE';
        }else{
            $u_from = 'CN';
        }

        $str .= '&u_from='.$u_from.'&rg_id='.$register_uuid;

        return $str;

    }

    public function getAfId($uuid,$account_type){
        $reg_tmp = RegisterTemp::where('register_uuid',$uuid)->first();
        $tmp_id = substr($reg_tmp->register_uuid,0,8).$reg_tmp->id;
        if($account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA){
            $region = 'CN';
        }elseif ($account_type == UsersExtends::ACCOUNT_TYPE_COMPANY_KENYA){
            $region = 'KE';
        }

        $AfId = 'AF_'.$region.'_'.$tmp_id;

        return $AfId;
    }

    public function updateBusinessLicenseImage($pic){
        if(!empty($pic)){
            if (!$pic->isValid()) {
                return false;
            }else{
                //获取后缀名
                $titles = $pic->getClientOriginalExtension();
                // 获取图片在临时文件中的地址
                $pic_path = $pic->getRealPath();
                // 制作文件名
                $key = time() . rand(10000, 99999999) . '.'.$titles;
                //阿里 OSS 图片上传
                $oss = Oss::getInstance();
                $result = $oss->put('business_license/'.$key, file_get_contents($pic_path));

                if (!$result) return false;
                return $oss->url('business_license/'.$key);
            }
        }
    }
}
