<?php

namespace App\Http\Requests;

use App\Traits\HasPlaceId;
use Illuminate\Foundation\Http\FormRequest;

class StoreManyItemsRequest extends FormRequest
{
    use HasPlaceId;
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
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.description' => ['nullable', 'string', 'max:1000'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.available' => ['required', 'boolean'],
            'items.*.photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
