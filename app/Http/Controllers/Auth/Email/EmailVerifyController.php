<?php

namespace App\Http\Controllers\Auth\Email;

use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function __construct(public Otp $otp){
        $this->middleware('throttle:emailVerify');
    }
    public function verify(Request $request)
    {
        $request->validate(['token' =>'required|max:6']);
        $user = $request->user();
        $sendOtp = $this->otp->validate($user->email, $request->token);
        if ($sendOtp->status == false) {
            return responseApi(400, 'code Invaild');
        }
        $user->update(['email_verified_at' => now()]);
        return responseApi(200, 'Email Verification Successfully');
    }
    public function resend(Request $request)
    {
        $user = $request->user();
        $user->notify(new SendOtpVerifyUserEmail());
        return responseApi(200, 'Otp Sent Successfully');
    }
}
