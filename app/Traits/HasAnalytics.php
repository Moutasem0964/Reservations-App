<?php

namespace App\Traits;

use App\Models\Analytics;

trait HasAnalytics
{
    /**
     * Log an analytics event for the given model.
     *
     * @param string $actionType
     * @param string $objectType
     * @param int $objectId
     * @return void
     */
    public function logAnalytics(string $actionType, string $objectType, int $objectId)
    {
        $user = auth()->user();

        Analytics::create([
            'user_id' => $user->id,
            'object_type' => $objectType,
            'object_id' => $objectId,
            'action_type' => $actionType,
        ]);
    }
}
