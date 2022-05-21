<?php

namespace App\Http\Api\V1\Controllers\Users\Auth;

use App\Http\BaseController;
use Domain\Users\Commands\VerifyPhoneCommand;
use Domain\Users\Models\User;
// use Illuminate\Http\Request;
use App\Exceptions\ErrorMessages as Message;
use App\Http\Api\V1\Requests\Users\Auth\VerifyOtpRequest as Request;

class VerifyOtpController extends BaseController
{
    public function __invoke(
        Request $request
    ) {
        $user = User::wherePhone($request->phone)->first();

        error_if ($user->is_blocked, Message::USER_BLOCKED);

        error_if ($user->verification_code !== $request->otp, Message::INVALID_OTP);

        $result = app(VerifyPhoneCommand::class)->execute($user, $request->remember_me ?? false, $request->server('HTTP_USER_AGENT'));

        return $this->response([
            'access_token'  => $result->plainTextToken,
            'user'          => [
                'id'    => $user->id,
                'phone' => $user->phone
            ]
        ]);
    }
}

/**
* @OA\Post(
*   path="/auth/verify-otp",
*   tags={"Auth"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Verify otp User",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/ApiV1AuthVerifyOtp")
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
*            @OA\Property(
*               property="access_token",
*               title="access_token",
*               type="string",
*               description="access_token of user",
*               example="16|LxF8r1v5asdfaizU3gr0Rt0Veio5AjjJdUG5kjf"
*            ),
*            @OA\Property(
*               property="user",
*               @OA\Property(
*                  property="id",
*                  title="id",
*                  type="integer",
*                  description="id of user",
*                  example="16"
*               ),
*               @OA\Property(
*                  property="phone",
*                  title="phone",
*                  type="integer",
*                  description="phone of user",
*                  example="62007125"
*               ),
*            )
*         ),
*     ),
*   ),
* )
*/
