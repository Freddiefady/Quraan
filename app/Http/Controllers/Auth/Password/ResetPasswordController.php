<?php

namespace App\Http\Controllers\Auth\Password;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }
    public function reset(Request $request)
    {
        $request->validate([
            'email' =>'required|email|exists:users,email|max:60',
            'token' =>'required|max:6',
            'password' =>'required|min:8|confirmed',
            'password_confirmation' =>'required'
        ]);

        $sendOtp = $this->otp->validate($request->email, $request->token);
        if($sendOtp->status == false){
            return responseApi(401, 'Codes Invalid');
        }

        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            return responseApi(404, 'User not found');
        }

        $user->update(['password'=>$request->password]);
        return responseApi(200, 'Password Reset Successfully');
    }
}
