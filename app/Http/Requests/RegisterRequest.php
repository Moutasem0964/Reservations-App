<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\Rules\Phone;

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

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => [
                'required',
                new Phone(['SY']), // Syria country code
                'phone:mobile',   // Only mobile numbers
                'unique:users'    // Prevent duplicates
            ],
            'password' => 'required|string|min:8|confirmed',
            'first_name_ar' => 'required|string|max:255',
            'last_name_ar' => 'required|string|max:255',
            'preferences' => 'nullable|array',
            'preferences.language' => 'required_with:preferences|string|in:en,ar',
            'photo' => [
                'sometimes',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ]
        ];
    }
}
