<?php

namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"phone_number", "password"},
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         example="+9639xxxxxxxx"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="your_password"
 *     )
 * )
 */
class LoginRequest {}
