<?php
namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="AcceptInviteRequest",
 *     required={"first_name", "last_name", "phone_number", "password", "password_confirmation", "first_name_ar", "last_name_ar"},
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="first_name_ar", type="string", example="جون"),
 *     @OA\Property(property="last_name_ar", type="string", example="دو"),
 *     @OA\Property(property="phone_number", type="string", example="+963944000000"),
 *     @OA\Property(property="password", type="string", example="password123"),
 *     @OA\Property(property="password_confirmation", type="string", example="password123"),
 *     @OA\Property(property="preferences", type="object", 
 *         @OA\Property(property="language", type="string", enum={"en", "ar"})
 *     )
 * )
 */
class AcceptInviteRequest {}