<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlaceController extends Controller
{


    public function place_activation_toggle($id)
    {
        DB::beginTransaction();
        try {
            $admin = auth()->user();
            $place = Place::findOrFail($id);
            $this->authorize('place_activation_toggle', $place);
            $newStatus = !$place->is_active;
            $place->is_active = $newStatus;
            $place->save();
            $action = $place->is_active ? 'activating place' : 'deactivating place';
            $admin->logAction($action, 'Place', $place->id);
            DB::commit();
            return response()->json([
                'message' => "Place {$action} successfully",
                'place' => new PlaceResource($place)
            ], 200);
        } catch (ModelNotFoundException $e) {
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








    public function destroy($id)
    {
        $place = Place::withTrashed()->findOrFail($id); // Include soft-deleted
        $place->forceDelete(); // Permanently delete

        return response()->json([
            'success' => true,
            'message' => 'Place permanently deleted.',
        ], 200);
    }
}
