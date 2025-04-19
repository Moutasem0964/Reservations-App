<?php
namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="ClientRegisterRequest",
 *     required={"first_name", "last_name", "phone_number", "password", "password_confirmation", "first_name_ar", "last_name_ar"},
 *     @OA\Property(property="first_name", type="string"),
 *     @OA\Property(property="last_name", type="string"),
 *     @OA\Property(property="first_name_ar", type="string"),
 *     @OA\Property(property="last_name_ar", type="string"),
 *     @OA\Property(property="phone_number", type="string", example="+9639XXXXXXXX"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="password_confirmation", type="string"),
 *     @OA\Property(property="preferences", type="object", @OA\Property(property="language", type="string", enum={"en", "ar"})),
 *     @OA\Property(property="photo", type="image", format="jpg,jpeg,png", nullable=true)
 * )
 */
class ClientResgisterRequest{}
