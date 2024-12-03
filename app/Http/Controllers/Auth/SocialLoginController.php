<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try {
            $user_provider = Socialite::driver($provider)->user();
            $user_from_db = Admin::whereEmail($user_provider->getEmail())->first();

            if($user_from_db){
                Auth::login($user_from_db);
                return responseApi(200, 'success', $user_from_db);
            }

            $username = $this->generateUniqueUserName($user_provider->name);

            $user = User::create([
                'name' => $username.time(),
                'email' => $user_provider->email,
                'status' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(8)),
            ]);

            Auth::login($user);
            return responseApi(200, 'logged in successfully', $user);

        } catch (\Exception $e) {
            return responseApi(500, 'Try again, Cannot login now');
        }
    }

    public function generateUniqueUsername($name)
    {
        $username = Str::slug($name);
        $count = 1 ;
        while(User::where('name' , $username)->exists()){
            $username = $username . $count++;
        }
        return $username;
    }
}
