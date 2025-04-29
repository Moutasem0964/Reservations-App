<?php

namespace App\Swagger\Item;

/**
 * @OA\Post(
 *     path="/api/representative/menu/store/many/items",
 *     operationId="storeManyItems",
 *     tags={"Items"},
 *     summary="Store multiple items in a menu. (Requires Manager or Employee privileges!)",
 *     security={{"Sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Bulk item creation payload",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/StoreManyItemsRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Items created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="created successfuly"),
 *             @OA\Property(
 *                 property="items",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Item")
 *             )
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
 *         description="Unauthorized action",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized action Requires Manager Or Employee Privileges"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated - Missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated")
 *         )
 *     )
 * )
 */
class StoreManyItemsEndpoint {}
