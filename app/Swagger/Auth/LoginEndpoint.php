<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Authenticate user with phone number and password",
 *     description="Logs in a user and returns an access token. Note: Account must be verified first.",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="User credentials",
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Authentication successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(
 *                 property="token",
 *                 type="string",
 *                 example="1|XNBb3Jz5Zk9L2wq1pOoPpQaRsTtUuVv",
 *                 description="Bearer token for authenticated requests"
 *             ),
 *             @OA\Property(property="user", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized - Invalid credentials",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Invalid phone number or password"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - Account not verified",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Unauthorized"
 *             ),
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 */
class LoginEndpoint {}