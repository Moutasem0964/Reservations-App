<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Item",
 *     type="object",
 *     required={"id", "menu_id", "name", "price", "available"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="menu_id", type="integer", example=3),
 *     @OA\Property(property="name", type="string", example="Grilled Chicken"),
 *     @OA\Property(property="description", type="string", example="Delicious grilled chicken", nullable=true),
 *     @OA\Property(property="price", type="number", format="float", example=15000),
 *     @OA\Property(property="available", type="boolean", example=true),
 *     @OA\Property(property="photo", type="string", example="https://example.com/storage/items/grilled-chicken.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-29T14:48:00.000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-29T14:48:00.000Z")
 * )
 */
class Item {}
