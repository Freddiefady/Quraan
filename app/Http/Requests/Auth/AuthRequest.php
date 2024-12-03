<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name.*' => 'required|string|min:5',
            'username.*' => 'sometimes|required|string|unique:admins,username',
            'email.*' => 'required|email|unique:users,email',
            'image.*'=>'nullable|mimes:png,jpeg,jpg|image',
            'email_verified_at'=>'in:0,1',
            'status'=>'in:0,1',
            'password.*'=>'required | confirmed | min:8',
            'password_confirmation.*'=>'required',
        ];
    }
}
