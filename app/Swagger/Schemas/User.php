<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Authenticated user data",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="معتصم Or Moutasem"),
 *     @OA\Property(property="last_name", type="string", example="قصاص Or Qassas"),
 *     @OA\Property(property="phone_number", type="string", example="+963912345678"),
 *     @OA\Property(property="photo", type="string", nullable=true, example="https://example.com/images/profile.jpg"),
 *     @OA\Property(
 *         property="preferences",
 *         type="object",
 *         example={"language": "en"}
 *     ),
 *     @OA\Property(property="role", type="string", example="manager"),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-19T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-19T10:00:00Z")
 * )
 */
class User {}
