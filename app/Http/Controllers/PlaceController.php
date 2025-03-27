<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{








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
