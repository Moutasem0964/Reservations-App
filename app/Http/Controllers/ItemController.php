<?php

namespace App\Http\Controllers;

use App\Helpers\StorageHelper;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\Menu;

class ItemController extends Controller
{
    public function store(StoreItemRequest $request)
    {
        $validatedData = $request->validated();

        $menu = Menu::findOrFail($validatedData['menu_id']);

        $this->authorize('create', [Item::class, $menu, $validatedData['place_id']]);

        $item = Item::create([
            'menu_id' => $validatedData['menu_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'available' => $validatedData['available'],
            'photo' => isset($validatedData['photo'])
                ? StorageHelper::storeFile($validatedData['photo'], 'ItemsPhotos')
                : null,
        ]);
        return response()->json([
            'message' => 'created successfuly in Menu: ' . $menu->name,
            'item' => $item,
        ], 201);
    }
}
