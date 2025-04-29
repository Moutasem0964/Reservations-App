<?php

namespace App\Swagger\Item;

/**
 * @OA\Post(
 *     path="/api/items",
 *     operationId="storeItem",
 *     tags={"Items"},
 *     summary="Create a new item in a menu. (Requires a Manager or Employee privileges!)",
 *     security={{"Sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Table creation data",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/StoreItemRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Item created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="created successfuly in Menu: Appetizers"),
 *             @OA\Property(property="item", ref="#/components/schemas/Item")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized action"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated - Missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated")
 *         )
 *     ),
 * )
 */
class StoreItemEndpoint {}
