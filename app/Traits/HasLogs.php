<?php

namespace App\Traits;


use App\Models\Log;

trait HasLogs
{
    /**
     * Log an action for the given model.
     *
     * @param string $actionType
     * @param string $objectType
     * @param int $objectId
     * @return void
     */
    public function logAction(string $actionType, string $objectType, int $objectId)
    {
        $user = auth()->user();

        Log::create([
            'user_id' => $user->id,
            'user_role' => $user->role,
            'action_type' => $actionType,
            'object_type' => $objectType,
            'object_id' => $objectId,
        ]);
    }
}

