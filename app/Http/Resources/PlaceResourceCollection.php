<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlaceResourceCollection extends ResourceCollection
{
    protected string $language;

    public function __construct($resource, string $language)
    {
        parent::__construct($resource);
        $this->language = $language;
    }

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return new PlaceResource($item, $this->language);
        });
    }
}
