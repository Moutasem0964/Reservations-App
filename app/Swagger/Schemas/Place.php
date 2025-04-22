<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Place",
 *     title="Place",
 *     description="A single place with multilingual fields and relationships",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Al Khan Restaurant"),
 *     @OA\Property(property="address", type="string", example="Damascus, Syria - Al Shaalan"),
 *     @OA\Property(property="phone_number", type="string", nullable=true, example="+963944XXXXXX"),
 *     @OA\Property(property="latitude", type="number", format="float", example=33.5138),
 *     @OA\Property(property="longitude", type="number", format="float", example=36.2765),
 *     @OA\Property(property="type", type="string", example="restaurant"),
 *     @OA\Property(property="reservation_duration", type="integer", example=2),
 *     @OA\Property(property="description", type="string", nullable=true, example="A beautiful place to enjoy Syrian cuisine."),
 *     @OA\Property(
 *         property="categories",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Property(
 *         property="reservations_types",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ResType")
 *     ),
 *     @OA\Property(property="photo_path", type="string", nullable=true, example="/storage/places/restaurant.jpg"),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-20T15:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-21T08:10:00Z")
 * )
 */
class Place {}
