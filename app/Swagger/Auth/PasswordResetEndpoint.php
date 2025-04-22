<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/reset/password",
 *     summary="Reset user password using phone number and reset token",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/PasswordResetRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password reset successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Password reset successful. Please login.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid or expired reset token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Invalid or expired reset token")
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
 *             @OA\Property(property="message", type="string", example="Something went wrong.")
 *         )
 *     )
 * )
 */
class PasswordResetEndpoint {}
