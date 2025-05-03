<?php

namespace App\Http\Requests;

use App\Traits\HasPlaceId;
use App\Traits\HasTranslations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreManyItemsRequest extends FormRequest
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
        $validator->after(function (Validator $validator) {
            // Validate translatable fields for each item in the "items" array
            if ($this->has('items') && is_array($this->input('items'))) {
                foreach ($this->input('items') as $index => $item) {
                    // Validate "description" and "description_ar" for this item
                    $this->validateTranslatableFields(
                        $this,
                        $validator,
                        ['items.' . $index . '.description'] // Fields to validate
                    );
                }
            }
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
            'menu_id' => ['required', 'exists:menus,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('items')->where(function ($query) {
                    return $query->where('menu_id', $this->menu_id);
                })
            ],
            'items.*.name_ar' => ['required', 'string', 'max:255'],
            'items.*.description' => ['nullable', 'string', 'max:1000'],
            'items.*.description_ar' => ['nullable', 'string', 'max:1000'], // handled in withValidator
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.available' => ['required', 'boolean'],
            'items.*.photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
