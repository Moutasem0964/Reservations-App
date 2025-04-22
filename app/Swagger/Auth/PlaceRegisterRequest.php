<?php

namespace App\Swagger\Auth;

/**
 * @OA\Schema(
 *     schema="PlaceRegisterRequest",
 *     required={"place_name", "place_name_ar", "place_address", "place_address_ar", "place_latitude", "place_longitude", "place_type", "categories", "res_types"},
 *
 *     @OA\Property(property="place_name", type="string", example="Sky Lounge"),
 *     @OA\Property(property="place_name_ar", type="string", example="سكاي لاونج"),
 *     @OA\Property(property="place_address", type="string", example="Damascus, Shaalan"),
 *     @OA\Property(property="place_address_ar", type="string", example="دمشق، الشعلان"),
 *     @OA\Property(property="place_latitude", type="number", format="float", example="33.5138"),
 *     @OA\Property(property="place_longitude", type="number", format="float", example="36.2765"),
 *     @OA\Property(property="place_type", type="string", enum={"restaurant", "cafe"}, example="restaurant"),
 *     @OA\Property(property="place_reservation_duration", type="integer", example=2, nullable=true),
 *     @OA\Property(property="place_description", type="string", nullable=true),
 *     @OA\Property(property="place_description_ar", type="string", nullable=true),
 *     @OA\Property(property="place_phone_number", type="string", example="+963944000000", nullable=true),
 *
 *
 *     @OA\Property(
 *         property="categories",
 *         type="array",
 *         @OA\Items(type="integer", example=1)
 *     ),
 *     @OA\Property(
 *         property="res_types",
 *         type="array",
 *         @OA\Items(type="integer", example=2)
 *     )
 * )
 */
class PlaceRegisterRequest{}