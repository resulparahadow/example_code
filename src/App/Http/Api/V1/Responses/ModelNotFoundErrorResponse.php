<?php

namespace App\Http\Api\V1\Responses;

/**
 * @OA\Schema(
 *     type="object",
 *     title="ModelNotFoundErrorResponse",
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
 *         example="MODEL_NOT_FOUND"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="description of error",
 *         example="model not found"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="integer",
 *         description="HTTP error code",
 *         example="404"
 *     )
 *  )
 */
class ModelNotFoundErrorResponse
{
}
