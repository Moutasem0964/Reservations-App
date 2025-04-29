<?php


namespace App\Swagger\Item;

/**
 * @OA\Schema(
 *     schema="StoreItemRequest",
 *     required={"menu_id", "name", "price"},
 *     type="object",
 *     @OA\Property(property="menu_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Grilled Chicken"),
 *     @OA\Property(property="description", type="string", example="Delicious grilled chicken with herbs", nullable=true),
 *     @OA\Property(property="price", type="number", format="float", example=15000),
 *     @OA\Property(property="available", type="boolean", example=true),
 *     @OA\Property(property="photo", type="string", format="binary")
 * )
 */
class StoreItemRequest {}

