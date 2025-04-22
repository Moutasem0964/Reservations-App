<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User data. Note: is_active will be false by default until user verifies their account and logs in.",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="first name in english or arabic based on the language in the preferences"),
 *     @OA\Property(property="last_name", type="string", example="last name in english or arabic based on the language in the preferences"),
 *     @OA\Property(property="phone_number", type="string", example="+9639xxxxxxxx"),
 *     @OA\Property(property="photo", type="string", nullable=true, example="https://example.com/images/profile.jpg"),
 *     @OA\Property(
 *         property="preferences",
 *         type="object",
 *         example={"language": "en"}
 *     ),
 *     @OA\Property(property="role", type="string", example="manager|employee|client|admin"),
 *     @OA\Property(
 *         property="is_active",
 *         type="boolean",
 *         default=false,
 *         example=false,
 *         description="Will be false by default until user verifies account and logs in"
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-19T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-19T10:00:00Z")
 * )
 */
class User {}
