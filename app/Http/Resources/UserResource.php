<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language = $this->preferences['language'] ?? 'en';


        return [
            'id' => $this->id,
            'first_name' => $this->getTranslation('first_name',$language),
            'last_name' => $this->getTranslation('last_name',$language),
            'phone_number' => $this->phone_number,
            'photo' => $this->photo_path,
            'preferences' => $this->preferences,
            'role' => $this->role,  // This will call the `getRoleAttribute` method
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
