<?php

namespace App\Http\Controllers;

use App\Helpers\StorageHelper;
use App\Http\Requests\StoreTableRequest;
use App\Models\Table;
use App\Models\TablePhoto;
use Exception;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function store(StoreTableRequest $request)
    {
        DB::beginTransaction();
        try {

            $validatedData = $request->validated();
            $table = Table::create([
                'place_id' => $validatedData['place_id'],
                'number' => $validatedData['number'],
                'capacity' => $validatedData['capacity'],
                'status' => true
            ]);

            $photoPath = null;
            if (isset($validatedData['photo'])) {
                $photoPath = StorageHelper::storeFile($validatedData['photo'], 'TablesPhotos');
            }

            if ($photoPath) {
                TablePhoto::create([
                    'table_id' => $table->id,
                    'photo' => $photoPath
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Table created successfully!',
                'table' => $table,
                'table_photo_path'=>$photoPath
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
