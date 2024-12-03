<?php

namespace App\Http\Controllers\Auth\Password;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpResetPassword;

class ForgetPasswordController extends Controller
{
    public function forget(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email|max:60']);
        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            return responseApi(404, 'Not Found User');
        }
        $user->notify(new SendOtpResetPassword());
        return responseApi(200, 'OTP Sent Successfully, check your email');
    }
}
