<?php

namespace App\Http\Requests;

use App\Traits\HasPlaceId;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTableRequest extends FormRequest
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
            'number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tables')->where(
                    fn($query) =>
                    $query->where('place_id', $this->place_id)
                ),
            ],
            'capacity' => ['required', 'integer', 'min:1'],
            'photo' => [
                'required',
                'image', // Ensure it's an image file
                'mimes:jpg,jpeg,png', // Allowed file types
                'max:2048', // Maximum file size in kilobytes (2MB)
            ],
        ];
    }
}
