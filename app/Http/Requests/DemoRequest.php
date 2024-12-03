<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemoRequest extends FormRequest
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
            'first_name.*'=>'required|string|max:10',
            'last_name.*'=>'required|string|max:10',
            'email.*'=>'required|email|max:50|unique:demo_models,email',
            'phone.*'=>'required|string|max:15|unique:demo_models,phone',
            'country.*'=>'required|string',
            'city.*'=>'required|string',
            'the_cycle'=>'required|string',
            'favorites_days'=>'required|string',
            'favorites_time'=>'required|string|max:10',
            'age.*'=>'required|numeric',
            'student_gender'=>'required|in:0,1',
            'teacher_gender'=>'required|in:0,1',
            'message.*'=>'required|string|max:150',
        ];
    }
}
