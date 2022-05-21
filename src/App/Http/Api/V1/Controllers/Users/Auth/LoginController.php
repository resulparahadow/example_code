<?php

namespace App\Http\Api\V1\Controllers\Users\Auth;

use App\Http\BaseController;
use Domain\Users\Models\User;
use App\Exceptions\ErrorMessages as Message;
use App\Http\Api\V1\Requests\Users\Auth\LoginRequest as Request;
use Domain\Users\Commands\GenerateAndSendOTPCommand;

class LoginController extends BaseController
{
    public function __invoke(
        Request $request
    ) {
        $user = User::firstOrCreate(
            ['phone'=> $request->phone]
        );

        error_if ($user->is_blocked, Message::USER_BLOCKED);

        $result = app(GenerateAndSendOTPCommand::class)->execute($user);

        return $this->response(['ok']);
    }
}

/**
* @OA\Post(
*   path="/auth/login",
*   tags={"Auth"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Login User",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/ApiV1AuthLogin")
*   ),
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
* )
*/
