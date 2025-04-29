<?php


namespace App\Swagger\Item;

/**
 * @OA\RequestBody(
 *     request="StoreItemRequest",
 *     required=true,
 *     @OA\MediaType(
 *         mediaType="multipart/form-data",
 *         @OA\Schema(
 *             required={"menu_id", "name", "price"},
 *             @OA\Property(property="menu_id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Grilled Chicken"),
 *             @OA\Property(property="description", type="string", example="Delicious grilled chicken with herbs", nullable=true),
 *             @OA\Property(property="price", type="number", format="float", example=15000),
 *             @OA\Property(property="available", type="boolean", example=true),
 *             @OA\Property(property="photo", type="string", format="binary")
 *         )
 *     )
 * )
 */
class StoreItemRequest {}
