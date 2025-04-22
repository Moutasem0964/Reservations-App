<?php

namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="ClientRegisterRequest",
 *     type="object",
 *     required={
 *         "first_name",
 *         "last_name",
 *         "phone_number",
 *         "password",
 *         "password_confirmation",
 *         "first_name_ar",
 *         "last_name_ar"
 *     },
 * 
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         maxLength=255,
 *         example="Ahmad"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         maxLength=255,
 *         example="Qassas"
 *     ),
 *     @OA\Property(
 *         property="first_name_ar",
 *         type="string",
 *         maxLength=255,
 *         example="أحمد"
 *     ),
 *     @OA\Property(
 *         property="last_name_ar",
 *         type="string",
 *         maxLength=255,
 *         example="قصاص"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="Syria mobile number starting with +963",
 *         example="+963944000000"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         minLength=8,
 *         example="StrongPass123"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         format="password",
 *         example="StrongPass123"
 *     ),
 *     @OA\Property(
 *         property="preferences",
 *         type="object",
 *         @OA\Property(
 *             property="language",
 *             type="string",
 *             enum={"en", "ar"},
 *             example="en"
 *         )
 *     ),
 * )
 */
class ClientResgisterRequest{}
