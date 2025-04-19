<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResTypeResource extends JsonResource
{
    protected string $language;

    public function __construct($resource, string $language = 'en')
    {
        parent::__construct($resource);
        $this->language = $language;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', $this->language),
        ];
    }

    public static function collection($resource, string $language = 'en')
    {
        return new ResTypeResourceCollection($resource, $language);
    }
}
