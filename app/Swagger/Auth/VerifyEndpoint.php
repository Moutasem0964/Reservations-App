<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/verify",
 *     summary="Verify user via phone number and code and generate reset token if needed",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/VerifyRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful verification. Note!! : if the Verification code was sent for resetting the password the response will include a reset token.",
 *         @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="message", type="string", example="Verification successful. Please Login!")
 *                 ),
 *                 @OA\Schema(
 *                     @OA\Property(property="message", type="string", example="Verification successful. Please reset the password"),
 *                     @OA\Property(property="reset_token", type="string", example="eyJ0eXAi..."),
 *                     @OA\Property(property="expires_at", type="string", format="date-time", example="2025-04-21T13:00:00Z")
 *                 )
 *             },
 *             example={
 *                 {"message": "Verification successful. Please Login!"},
 *                 {"message": "Verification successful. Please reset the password", "reset_token": "eyJ0eXAi...", "expires_at": "2025-04-21T13:00:00Z"}
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid or expired verification code",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Invalid or expired verification code")
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
class VerifyEndpoint {}