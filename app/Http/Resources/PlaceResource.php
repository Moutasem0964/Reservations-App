<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function __construct($resource, protected string $language = 'en')
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', $this->language),
            'address' => $this->getTranslation('address', $this->language),
            'phone_number' => $this->phone_number,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'type' => $this->getTranslation('type', $this->language),
            'reservation_duration' => $this->reservation_duration,
            'description' => $this->getTranslation('description', $this->language),
            'photo_path' => $this->photo_path,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
