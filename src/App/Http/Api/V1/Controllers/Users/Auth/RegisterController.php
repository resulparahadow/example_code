<?php

namespace App\Http\Api\V1\Controllers\Users\Auth;

use App\Http\BaseController;
use Domain\Users\Commands\CreateUserCommand;
use Domain\Users\Models\User;
// use Illuminate\Http\Request;
use App\Exceptions\ErrorMessages as Message;
use App\Http\Api\V1\Requests\Users\Auth\RegisterRequest as Request;

class RegisterController extends BaseController
{
    public function __invoke(
        Request $request
    ) {

        // $user = User::wherePhone($request->phone)->first();

        // error_if ($user, Message::PHONE_NOT_UNIQUE);

        $result = app(CreateUserCommand::class)->execute($request->all());

        return $this->response(['ok']);
    }
}
