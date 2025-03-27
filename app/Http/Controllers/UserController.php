<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update($id)
    {
        $admin = auth()->user();
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->is_active = !$user->is_active;
        $user->save();

        $action = $user->is_active ? 'activating user' : 'deactivating user';
        $admin->logs()->create([
            'user_id' => $admin->id,
            'user_role'=>$admin->role,
            'action_type' => $action,
            'object_type' => 'User',
            'object_id' => $user->id
        ]);

        return response()->json([
            'message' => "User {$action} successfully",
            'user' => new UserResource($user)
        ], 200);
    }
}
