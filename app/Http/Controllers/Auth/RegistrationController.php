<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Utils\ImageManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Auth\AuthRequest;
use App\Notifications\SendOtpVerifyUserEmail;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    public function store(AuthRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $admin = Admin::create([
                'name'=>$request->post('name'),
                'username'=>$request->post('username'),
                'email'=>$request->post('email'),
                'password'=>$request->post('password'),
            ]);

            if (!$admin) {
                return responseApi(404, 'Try again to register later.');
            }

            if($request->hasFile('image')) {
                if($request->hasFile('image')) {
                    ImageManager::UploadImages($request, $admin);
                }
            }
            $token = $admin->createToken('admin_token')->plainTextToken;

            $admin->notify(new SendOtpVerifyUserEmail());
            DB::commit();
            return responseApi(201, 'Admin Created Successfully', ['token'=>$token]);
        } catch (\Exception $e) {
            DB::rollBack();
            return responseApi(500, 'Failed to create account. Try again later.');
        }
    }
}
