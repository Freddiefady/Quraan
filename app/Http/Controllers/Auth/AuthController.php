<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('loginForm');
        $this->middleware(['guest:admin', 'throttle:login'])->only('loginForm');
    }
    public function loginForm(Request $request)
    {
        $request->validate([
            'email' =>'required|email|max:50',
            'password' =>'required|min:6|max:255',
            'remember' => 'in:on,off'
        ]);

        if (RateLimiter::tooManyAttempts($request->ip(), 2)){
            $time = RateLimiter::availableIn($request->ip());
            return responseApi(429, 'Invalid, Try again after : ' . $time . 'Minutes');
        }
        RateLimiter::increment($request->ip());
        $remaining = RateLimiter::remaining($request->ip(), 2);

        $user = Admin::whereEmail($request->email)->first();
        if($user && Hash::check($request->password, $user->password))
        {
            // Check if remember me is selected
            $remember = $request->has('remember') && $request->remember === 'on';

            $token = $user->createToken('user_token', [],$remember ? now()->addDays(30) : now()->addMinutes(60))->plainTextToken;
            RateLimiter::clear($request->ip());
            return responseApi(200, 'User logged in successfully',['token' => $token]);
        }
        return responseApi( 401,'Credentials doesn\'t match, Try again', ['remaining'=>$remaining]);
    }
    public function logout()
    {
        $user = auth('sanctum')->user();
        $user->currentAccessToken()->delete();
        return responseApi(200, 'User logged out successfully');
    }
    public function logoutAllDevices()
    {
        $user = auth('sanctum')->user();
        $user->tokens()->delete();
        return responseApi(200, 'User Logged out from all devices successfully');
    }
}
