<?php

namespace App\Swagger\Auth;

/**
 * @OA\Post(
 *     path="/api/manager/send/invitation",
 *     summary="Send manager invitation",
 *     tags={"Authentication"},
 *     security={{"sanctum": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/SendManagerInviteRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Invitation sent",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Your invitation has been sent.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - not authorized to send invitations",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="This action is unauthorized.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=429,
 *         description="Too many requests",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="An invitation was already sent to this number within the last 5 minutes. Please wait before sending another.")
 *         )
 *     )
 * )
 */
class SendManagerInviteEndpoint {}
