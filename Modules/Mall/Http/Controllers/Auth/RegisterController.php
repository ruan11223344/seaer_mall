<?php

namespace Modules\Mall\Http\Controllers\Auth;


use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\EchoJson;

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
            'account_type' => $data['account_type']
        ]);
    }


    public function register(Request $request)
    {
        if(Auth::check()){
            return $this->echoJson('您已经登录无法进行注册!',400);
        }

        $this->validator($request->all())->validate();

        try{
            DB::beginTransaction();
            event(new Registered($user = $this->create($request->all())));

            $wx_open_id  =  $request->input('wx_open_id',null);
            $wx_nick_name  =  $request->input('wx_nick_name',null);
            $random_str  =  $request->input('random_str',null);


            AnchorVerifyModel::create([
                'wx_open_id' => $wx_open_id,
                'wx_nick_name' => $wx_nick_name,
                'random_str' => $random_str,
                'user_id'=>$user->id,
                'verify_status'=>0
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->echoErrorJson('注册失败',[$e->getMessage()]);
        }

        $this->guard()->login($user);

        $token = $user->createToken(null)->accessToken;

        return $this->echoSuccessJson('注册成功!',['access_token'=>$token,'user_info'=>$user]);
    }
}
