<?php
namespace App\Swagger;

/**
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Sanctum Token",
 *     description="Enter Sanctum token in the format: Bearer {token}"
 * )
 */
class SecuritySchemes {}