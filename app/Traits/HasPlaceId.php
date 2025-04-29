<?php

namespace App\Traits;

trait HasPlaceId
{
    public function injectPlaceId()
    {
        $user = auth()->user();
        $userAsRole = $user->manager ??
            $user->employee ??
            abort(403, 'Unauthorized action');
        $place_id = $userAsRole->place_id;
        $this->merge([
            'place_id' => $place_id
        ]);
    }
}
