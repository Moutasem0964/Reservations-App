<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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

    public function rules(){
        return [
            'first_name' => 'required|string|max:255',   
            'last_name' => 'required|string|max:255',    
            'phone_number' => 'required|string|unique:users,phone_number|size:10',
            'password' => 'required|string|min:8|confirmed',
            'photo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'preferences' => 'nullable|json',
        ];
    }

}
