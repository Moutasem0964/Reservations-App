<?php 
namespace App\Swagger\Auth;


/**
 * @OA\Post(
 *     path="/api/manager/register",
 *     summary="Register a new manager and their place. Note!: Both the Manager and the Place accounts will be inactive till verification",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(ref="#/components/schemas/ClientRegisterRequest"),
 *                 @OA\Schema(ref="#/components/schemas/PlaceRegisterRequest")
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Manager and Place registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Registration successful Please Verify!"),
 *             @OA\Property(property="user", ref="#/components/schemas/User"),
 *             @OA\Property(property="place", ref="#/components/schemas/Place")
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

 class ManagerRegisterEndpoint{}
