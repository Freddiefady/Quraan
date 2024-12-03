<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursesRequest extends FormRequest
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
            'title.*'=>'required|string',
            'description.*'=>'required|string|max:250',
            'price'=>'required|string',
            'user_id'=>'sometimes|exists:users,id',
            'sheikh_id'=>'required|exists:sheikhs,id',
            'admin_id'=>'required|exists:admins,id',
        ];
    }
}
