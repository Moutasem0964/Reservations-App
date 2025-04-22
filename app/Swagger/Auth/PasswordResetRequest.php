<?php

namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="PasswordResetRequest",
 *     required={"phone_number", "password", "password_confirmation", "reset_token"},
 *     @OA\Property(property="phone_number", type="string", example="+963944000000"),
 *     @OA\Property(property="password", type="string", format="password", example="newSecurePassword123"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="newSecurePassword123"),
 *     @OA\Property(property="reset_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOi...")
 * )
 */
class PasswordResetRequest {}
