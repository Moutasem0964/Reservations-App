<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Place;
use Illuminate\Auth\Access\AuthorizationException;

class ManagerInvitationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function send(User $user)
    {
        if (!$user->is_active) {
            throw new AuthorizationException('Your account is not active.');
        }

        if (!$user->manager) {
            throw new AuthorizationException('You are not a manager.');
        }

        if (!$user->manager->place) {
            throw new AuthorizationException('You are not assigned to a place.');
        }

        if (!$user->manager->place->is_active) {
            throw new AuthorizationException('Your place is not active.');
        }

        return true;
    }
}
