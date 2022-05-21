<?php

namespace App\Http\Api\V1\Controllers\Users\Auth;

use App\Http\BaseController;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{
    public function __invoke(
        Request $request
    ) {

        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();
        }

        return $this->response('ok');
    }
}

/**
* @OA\Get(
*   path="/auth/logout",
*   tags={"Auth"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Logout User",
*   @OA\Response(
*     response="200",
*     description="result",
*     @OA\JsonContent(
*         @OA\Property(
*            property="success",
*            title="status",
*            type="boolean",
*            description="result status"
*         ),
*         @OA\Property(
*            property="data",
*            title="data",
*            type="json",
*            description="result data"
*         ),
*     ),
*   ),
*   @OA\Response(
*     response="403",
*     description="result forbidden",
*     @OA\JsonContent(
*         @OA\Property(
*            property="success",
*            title="status",
*            type="boolean",
*            example="false",
*            description="result status"
*         ),
*         @OA\Property(
*            property="data",
*            title="data",
*            type="json",
*            description="result data"
*         ),
*     ),
*   ),
* )
*/
