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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
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
            $auth = new AuthorizationsController();
            return $auth->getUserInfo();
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
