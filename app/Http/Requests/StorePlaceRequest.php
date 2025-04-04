<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\Rules\Phone;

class StorePlaceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'place_name' => 'required|string|max:255',
            'place_name_ar' => 'required|string|max:255',
            'place_address' => 'required|string|max:255',
            'place_address_ar' => 'required|string|max:255',
            'place_phone_number' => [
                'nullable',
                new Phone(['SY']),
                'phone:mobile'
            ],
            'place_latitude' => [
                'required',
                'numeric',
                'between:-90,90',
                function ($attribute, $value, $fail) {
                    if ($value == 0 && request('place_longitude') == 0) {
                        $fail('The default (0,0) location is not allowed.');
                    }
                }
            ],
            'place_longitude' => 'required|numeric|between:-180,180',
            'place_type' => 'required|in:restaurant,cafe',
            'place_reservation_duration' => 'sometimes|integer|min:1|max:24',
            'place_description' => 'nullable|string',
            'place_description_ar' => 'nullable|string',
            'place_photo' => 'nullable|image|max:2048',
            'categories' => 'required|array', // Ensure 'categories' is an array
            'categories.*' => 'integer|exists:categories,id', // Each item must be a valid ID from the categories table
        ];
    }

    public function messages()
    {
        return [
            'latitude.between' => 'Latitude must be between -90 and 90 degrees',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees',
        ];
    }
}
