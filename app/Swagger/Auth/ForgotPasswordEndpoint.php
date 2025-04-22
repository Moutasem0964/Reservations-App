<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/forgot/password",
 *     summary="Send password reset verification code to the user's phone",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"phone_number"},
 *             @OA\Property(property="phone_number", type="string", example="+963944000000")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Verification code sent successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Verification Code has been sent to your phone number. Please verify !"),
 *             @OA\Property(property="expires_in", type="integer", example=5)
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Could not process password reset")
 *         )
 *     )
 * )
 */
class ForgotPasswordEndpoint {}
