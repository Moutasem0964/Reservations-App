<?php

namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="SendManagerInviteRequest",
 *     required={"phone_number"},
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         example="+963944000000",
 *         description="Phone number to invite (must be a mobile number in Syria and not already registered)"
 *     )
 * )
 */
class SendManagerInviteRequest {}
