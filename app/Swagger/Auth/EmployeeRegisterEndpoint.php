<?php
namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/employee/register",
 *     summary="Register a new employee (Requires Manager privileges)",
 *     tags={"Authentication"},
 *     security={{"sanctum": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Employee registration data",
 *         @OA\JsonContent(ref="#/components/schemas/ClientRegisterRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Employee registered successfully",
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
 *         description="Forbidden - Requires Manager privileges",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized - Manager token required")
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
class EmployeeRegisterEndpoint{}