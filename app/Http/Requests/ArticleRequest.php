<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $rules = [
            'title.*' =>'required|string|max:150',
            'image.*' =>'image|mimes:jpg,jpeg,png,gif|image',
            'content.*' =>'required|string|max:250',
            'status' =>'nullable|in:0,1',
            'satisfied' =>'required|in:0,1',
            'admin_id' =>'required|exists:admins,id',
            'rating_id' =>'required|exists:ratings,id',
        ];
        if (in_array($this->method(), ['PUT','PATCH']))
        {
            $rules['images']='nullable';
        }else{
            $rules['images']='required';
        }
        return $rules;
    }
}
