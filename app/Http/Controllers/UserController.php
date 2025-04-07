<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function user_activation_toggle($id)
    {
        DB::beginTransaction();
        try{
            $admin = auth()->user();
        $user = User::findOrFail($id);
        $this->authorize('user_activation_toggle', $user);
        $newStatus= !$user->is_active;
        $user->is_active=$newStatus;
        $user->save();

        $action = $user->is_active ? 'activating user' : 'deactivating user';
        $admin->logAction($action,'User',$user->id);

        DB::commit();

        return response()->json([
            'message' => "User {$action} successfully",
            'user' => new UserResource($user)
        ], 200);

        }catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Place not found'], 404);
        } catch (AuthorizationException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Unauthorized action'], 403);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Place activation toggle failed: " . $e->getMessage());
            return response()->json([
                'message' => 'Failed to toggle place status',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
        
    }

    public function show($id){
        $user=User::findOrFail($id);
        return response()->json(new UserResource($user), 200);
    }
}
