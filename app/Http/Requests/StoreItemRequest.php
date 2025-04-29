<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $user = auth()->user();
        $userAsRole = $user->manager ??
            $user->employee ??
            abort(403, 'Unauthorized action');
        $place_id = $userAsRole->place_id;
        $this->merge([
            'UserAsRole' => $userAsRole,
            'place_id' => $place_id
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'UserAsRole' => 'required',
            'place_id' => 'required',
            'menu_id' => 'required|exists:menus,id',
            'name' => ['required', 'string', 'max:255', Rule::unique('items')->where(function ($query) {
                return $query->where('menu_id', $this->menu_id);
            })],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'available' => 'nullable|boolean',
            'photo' => [
                'nullable',
                'image', // Ensure it's an image file
                'mimes:jpg,jpeg,png', // Allowed file types
                'max:2048', // Maximum file size in kilobytes (2MB)
            ],
        ];
    }
}
