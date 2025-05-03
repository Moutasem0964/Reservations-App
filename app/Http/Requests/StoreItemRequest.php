<?php

namespace App\Http\Requests;

use App\Traits\HasPlaceId;
use App\Traits\HasTranslations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItemRequest extends FormRequest
{
    use HasPlaceId, HasTranslations;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->injectPlaceId();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateTranslatableFields($this, $validator, ['description']);
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'place_id' => ['required', 'exists:places,id'],
            'menu_id' => 'required|exists:menus,id',
            'name' => ['required', 'string', 'max:255', Rule::unique('items')->where(function ($query) {
                return $query->where('menu_id', $this->menu_id);
            })],
            'name_ar' => ['required', 'string', 'max:255'],
            'description' => 'nullable|string|max:1000',
            'description_ar' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'available' => 'required|boolean',
            'photo' => [
                'nullable',
                'image', // Ensure it's an image file
                'mimes:jpg,jpeg,png', // Allowed file types
                'max:2048', // Maximum file size in kilobytes (2MB)
            ],
        ];
    }
}
