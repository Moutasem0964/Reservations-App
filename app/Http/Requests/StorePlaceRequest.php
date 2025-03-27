<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaceRequest extends FormRequest
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
            'place_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'place_phone_number' => 'nullable|string|unique:places,phone_number|size:10',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'type' => 'required|in:restaurant,cafe',
            'reservation_duration' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string|max:2000',
            'place_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Max size 2MB
        ];
    }
}
