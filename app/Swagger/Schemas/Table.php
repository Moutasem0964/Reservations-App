<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Table",
 *     type="object",
 *     required={"id", "place_id", "number", "capacity", "status", "table_photo_path"},
 * 
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the table",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="place_id",
 *         type="integer",
 *         description="ID of the place where the table is located",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="integer",
 *         description="Number assigned to the table",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="capacity",
 *         type="integer",
 *         description="How many people can sit at the table",
 *         example=6
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="boolean",
 *         description="Table status (true for active, false for inactive)",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2025-04-28T12:00:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last updated timestamp",
 *         example="2025-04-28T12:30:00.000000Z"
 *     )
 * )
 */
class Table {}
