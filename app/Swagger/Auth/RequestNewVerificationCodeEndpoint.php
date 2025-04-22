<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/request/new/verification/code",
 *     summary="Request a new phone verification code if the account is not verified",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"phone_number"},
 *             @OA\Property(property="phone_number", type="string", example="+963944000000") *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New verification code sent",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="A new verification code has been sent. Please verify within 1"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Account already verified",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Account already verified")
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
class RequestNewVerificationCodeEndpoint {}
