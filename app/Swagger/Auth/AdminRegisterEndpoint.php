<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/admin/register",
 *     summary="Register a new admin (Requires Super Admin privileges)",
 *     tags={"Authentication"},
 *     security={{"sanctum": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Admin registration data",
 *         @OA\JsonContent(ref="#/components/schemas/ClientRegisterRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Admin registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Registration successful. Please Verify!"),
 *             @OA\Property(property="user", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated - Missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - Requires Super Admin privileges",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized - Super Admin token required")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation errors",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Something went wrong.")
 *         )
 *     )
 * )
 */
class AdminRegisterEndpoint {}