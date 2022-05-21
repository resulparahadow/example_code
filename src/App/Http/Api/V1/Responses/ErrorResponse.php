<?php

namespace App\Http\Api\V1\Responses;

/**
 * @OA\Schema(
 *     type="object",
 *     title="ErrorResponse",
 *     description="Error response data",
 *     @OA\Property(
 *         property="success",
 *         type="boolean",
 *         description="request status",
 *         example="false"
 *     ),
 *     @OA\Property(
 *         property="error",
 *         type="string",
 *         description="error constant",
 *         example="ALREADY_EXISTS"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="description of error",
 *         example="resource already exists"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="integer",
 *         description="HTTP error code",
 *         example="409"
 *     )
 *  )
 */
class ErrorResponse
{
}
