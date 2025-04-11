<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    protected string $language;

    public function __construct($resource, string $language = 'en')
    {
        parent::__construct($resource);
        $this->language = in_array($language, ['en', 'ar']) ? $language : 'en';
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
            'categories' => $this->whenLoaded('categories', function () {
                return CategoryResource::collection(
                    $this->categories,
                    $this->language
                );
            }),
            'reservations_types' => $this->whenLoaded('res_types', function () {
                return ResTypeResource::collection(
                    $this->res_types,
                    $this->language
                );
            }),
            'photo_path' => $this->photo_path,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public static function collection($resource, string $language = 'en')
    {
        return new PlaceResourceCollection($resource, $language);
    }
}
