<?php

namespace Modules\Mall\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{

    public function forgetPassword(){}

    public function resetPassword()
    {

    }

    use ResetsPasswords;

}
