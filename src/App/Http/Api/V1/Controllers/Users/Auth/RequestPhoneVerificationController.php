<?php

namespace App\Http\Api\V1\Controllers\Users\Auth;

use App\Http\BaseController;
use Illuminate\Http\Request;
use App\Exceptions\ErrorMessages as Message;
use Domain\Customers\Commands\GenerateAndSendOTPCommand;
use Domain\Users\Models\User;

class RequestPhoneVerificationController extends BaseController
{
    public function __invoke(
        Request $request
    ) {
        $user = User::wherePhone($request->phone)->first();

        error_if (!$user, Message::USER_NOT_FOUND);

        error_if ($user->is_blocked, Message::USER_BLOCKED);

        app(GenerateAndSendOTPCommand::class)->execute($user);

        return $this->response(['ok']);
    }
}
