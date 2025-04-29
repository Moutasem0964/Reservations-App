<?php

namespace App\Http\Controllers;

use App\Helpers\StorageHelper;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\StoreManyItemsRequest;
use App\Models\Item;
use App\Models\Menu;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function store(StoreItemRequest $request)
    {
        $validatedData = $request->validated();

        $menu = Menu::findOrFail($validatedData['menu_id']);

        if (!$this->authorize('create', [Item::class, $menu, $validatedData['place_id']])) {
            return response()->json([
                'message' => 'Unauthorized action !! the selcted item is not for your place.'
            ], 401);
        }

        $item = Item::create([
            'menu_id' => $validatedData['menu_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'price' => $validatedData['price'],
            'available' => $validatedData['available'] ?? true,
            'photo' => isset($validatedData['photo'])
                ? StorageHelper::storeFile($validatedData['photo'], 'ItemsPhotos')
                : null,
        ]);
        return response()->json([
            'message' => 'created successfuly in Menu: ' . $menu->name,
            'item' => $item,
        ], 201);
    }

    public function storeManyItems(StoreManyItemsRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            $menu = Menu::findOrFail($validatedData['menu_id']);
            $this->authorize('create', [Item::class, $menu, $validatedData['place_id']]);

            $createdItems = [];

            foreach ($validatedData['items'] as $item) {
                $createdItem = Item::create([
                    'menu_id' => $menu->id,
                    'name' => $item['name'],
                    'description' => $item['description'] ?? null,
                    'price' => $item['price'],
                    'available' => $item['available'] ?? true,
                    'photo' => isset($item['photo'])
                        ? StorageHelper::storeFile($item['photo'], 'ItemsPhotos')
                        : null,
                ]);

                $createdItems[] = $createdItem;
            }

            DB::commit();

            return response()->json([
                'message' => 'Items created successfully in Menu: ' . $menu->name,
                'items' => $createdItems,
            ], 201);
        }catch(AuthorizationException $e){
            return response()->json([
                'message' => 'the selected menu is not for your place!! '.$e->getMessage()
            ], 401);
        }
        catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create items.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
