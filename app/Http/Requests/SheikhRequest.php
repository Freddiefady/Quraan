<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SheikhRequest extends FormRequest
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
            'name' =>'required|string|max:50',
            'email' =>'required|email|unique:sheikhs,email',
            'phone' =>'required|string|max:15|unique:sheikhs,email',
            'image' =>'required|image|mimes:jpeg,jpg,png',
            'age' =>'required|integer',
            'gender' =>'required|string|in:0,1',
            'vacation' =>'required|string|in:0,1',
            'studies' =>'required|string|in:0,1',
            'level_of_english'=>'required|string',
            'education' =>'required|string',
            'links' =>'required|url',
            'cv'=>'required|mimes:pdf,application/msword',
            'recommendations' =>'required|string',
            'time_available' =>'required|string',
            'description' =>'required|string|max:150',
            'title' =>'required|string',
            'experience'=>'required|string',
        ];
    }
}
