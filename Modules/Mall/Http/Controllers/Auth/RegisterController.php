<?php

namespace Modules\Mall\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Utils\EMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Utils\EchoJson;
use Modules\Mall\Entities\Company;
use Modules\Mall\Entities\RegisterTemp;
use Modules\Mall\Entities\UsersExtends;
use Modules\Mall\Entities\User;
use Modules\Mall\Http\Controllers\CaptchaController;
use Webpatser\Uuid\Uuid;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{

    use EchoJson;
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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|between:6,20|alpha_dash|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' =>  [
                'required',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,20}$/',
                'between:6,20'
            ],
            'account_type' =>'in:0,1,2,3|required',
            'company_name' => 'required_if:account_type,0|required_if:account_type,1|string|between:2,30|alpha_dash',
            'company_name_in_china'=>[
                'required_if:account_type,0',
                'regex:/[\u4e00-\u9fa5]{2,25}/',
            ],
            'company_detailed_address'=>'required|string|between:5,30',
            'business_type'=>'exists:business_type,name',
            'business_range'=>'exists:business_range,name',
            'business_license'=>'alpha_num|between:5,1024',
            'china_business_license'=>[
                'required_if:account_type,0',
                'regex:/(^(?:(?![IOZSV])[\dA-Z]){2}\d{6}(?:(?![IOZSV])[\dA-Z]){10}$)|(^\d{15}$)/',
            ],
            'kenya_business_license'=>'alpha_num|between:9,12',
            'business_license_img'=>'image|between:5,1024',
        ]);
    }

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
        if(Auth::check()){
            return $this->echoJson('您已经登录,无法进行注册!',400);
        }

        $this->validator($request->all())->validate();

        try{
            DB::beginTransaction();
            event(new Registered($user = $this->create($request->all())));

            if((integer)in_array($request->input('account_type'),
                [
                    UsersExtends::ACCOUNT_TYPE_COMPANY_CHINA,
                    UsersExtends::ACCOUNT_TYPE_COMPANY_KENYA
                ]
            //is company users
            )){
              $company = Company::create(
                  [
                        'user_id'=>$user->id,
                        'company_name'=>$request->input(''),
                        'company_country_id'=>$request->input(''),
                        'company_region_id'=>$request->input(''),
                        'company_name_in_china'=>$request->input('china_username',null),
                        'company_business_type_id'=>$request->input('business_type'),
                        'company_business_range_id'=>$request->input('business_range'), //input array
                        'company_business_license'=>$request->input('business_license'),
                        'company_business_license_pic_url'=>$request->input('business_license_img'),
                    ]
                );

              $user_extends = UsersExtends::create(
                  [
                        'user_id'=>$user->id,
                        'af_id'=>'',
                        'company_id'=>$company->id,
                        'account_type'=>'',
                        'country_id'=>'',
                        'region_id'=>'',
                        'calling_code'=>'',
                        'mobile'=>'',
                        'sex'=>'',
                        'contact_full_name'=>'',
                        'chinese_name'=>'',
                    ]
                );

            }
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

    public function sendRegisterEmail(Request $request){
        $data = $request->all();
        $messages = [
            'member_id.required'=>'please input member_id',
            'captcha.required' => 'please input captcha',
            'captcha.captcha_api' => 'captcha error,please retry!',
            'i_agree' => 'you must be agree agreenment!'
        ];

        $validator = Validator::make($data, [
            'member_id'=>'required|string|between:6,20|alpha_dash|unique:users,name|unique:register_temp,name',
            'member_id'=>[
                'required',
                'string',
                'between:6,20',
                'alpha_dash',
                'unique:users,name',
                Rule::unique('register_temp','name')->where(function ($query) {
                $query->where('created_at','>',Carbon::now()->parse("24 hours ago")->toDateTimeString());
                }),
            ],
            'key' => 'required',
            'captcha' => 'required|captcha_api:' . $request->input('key'),
            'email' => 'email|required|unique:users,email',
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
            if($email_obj->send($email,$subject,[
                'register_url'=>$this->getRegisterUrl($data['account_type'],$register_uuid)],$email_obj::TEMPLATE_REGISTER)){
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
        $str = 'https://'.env('MALL_DOMAIN').'/auth/register?';
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
}
