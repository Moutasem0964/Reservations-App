<?php

namespace App\Swagger\Item;

/**
 * @OA\Schema(
 *     schema="StoreManyItemsRequest",
 *     required={"menu_id", "items"},
 *     @OA\Property(property="menu_id", type="integer", example=7),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"name", "price"},
 *             @OA\Property(property="name", type="string", example="Grilled Chicken Breast"),
 *             @OA\Property(property="description", type="string", example="Juicy grilled chicken with herbs", nullable=true),
 *             @OA\Property(property="price", type="number", format="float", example=22.50),
 *             @OA\Property(property="available", type="boolean", example=true),
 *             @OA\Property(property="photo", type="string", format="binary")
 *         )
 *     )
 * )
 */

class StoreManyItemsRequest {}