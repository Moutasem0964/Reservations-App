<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    protected string $language;
    public function __construct($resource, string $language = 'en')
    {
        parent::__construct($resource);
        $this->language = in_array($language, ['en', 'ar']) ? $language : 'en';
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'menu_id' => $this->menu_id,
            'name' => $this->getTranslation('name',$this->language),
            'description' => $this->getTranslation('description',$this->language),
            'price' => $this->price,
            'available' => $this->available,
            'photo' => $this->photo
        ];
    }
}
