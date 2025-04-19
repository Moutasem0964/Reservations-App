<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/login",
 *     summary="Login using phone number and password",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="You are logged in"),
 *             @OA\Property(property="token", type="string", example="1|yourgeneratedtoken..."),
 *             @OA\Property(property="user", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Wrong credentials"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized"
 *     )
 * )
 */
class LoginEndpoint {}
