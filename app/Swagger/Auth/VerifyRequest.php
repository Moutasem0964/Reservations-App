<?php

namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="VerifyRequest",
 *     required={"phone_number", "verification_code"},
 *     @OA\Property(property="phone_number", type="string", example="+963944000000"),
 *     @OA\Property(property="verification_code", type="string", example="ABCD1234")
 * )
 */
class VerifyRequest {}
