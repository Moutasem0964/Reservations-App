<?php

namespace App\Swagger\Table;

/**
 * @OA\Schema(
 *     schema="CreateTableRequest",
 *     type="object",
 *     required={"number", "capacity", "photo"},
 * 
 *     @OA\Property(
 *         property="number",
 *         type="integer",
 *         description="Table number inside the place",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="capacity",
 *         type="integer",
 *         description="Number of people the table can hold",
 *         example=6
 *     ),
 *     @OA\Property(
 *         property="photo",
 *         type="string",
 *         format="binary",
 *         description="Photo of the table"
 *     )
 * )
 */
class CreateTableRequest {}
