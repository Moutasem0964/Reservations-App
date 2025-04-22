<?php
namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/accept/manager/invite/{token}",
 *     summary="Accept manager invitation",
 *     tags={"Authentication"},
 *     @OA\Parameter(
 *         name="token",
 *         in="path",
 *         required=true,
 *         description="Invitation token",
 *         @OA\Schema(type="string", example="abc123token")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/AcceptInviteRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Manager registered and verification code sent",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Registered successfully. A verification code was sent to your phone number. Please verify your account")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid or used invitation",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Invalid or expired invitation.")
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
class AcceptInviteEndpoint {}