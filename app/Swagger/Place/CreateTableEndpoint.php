<?php

namespace App\Swagger\Table;

/**
 * @OA\Post(
 *     path="/api/representative/tables",
 *     summary="Create a new table",
 *     tags={"Tables"},
 *     security={{"sanctum": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Table creation data",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/CreateTableRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Table created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Table created successfully!"),
 *             @OA\Property(property="table", ref="#/components/schemas/Table"),
 *             @OA\Property(property="table_photo_path", type="string", example="TablesPhotos/photo123.jpg")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated - Missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - Unauthorized action",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized action.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation errors",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Something went wrong.")
 *         )
 *     )
 * )
 */
class CreateTableEndpoint {}
