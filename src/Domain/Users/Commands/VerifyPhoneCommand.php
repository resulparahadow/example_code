<?php

namespace Domain\Users\Commands;

use Domain\Users\Models\User;

class VerifyPhoneCommand
{
    public function execute(User $user, bool $rememberMe, $agent = null)
    {
        $user->verification_code = null;

        $user->save();

        $expirationMinutes = $rememberMe
            ? config('sanctum.long_live_token_expiration')
                : config('sanctum.expiration');

        $tokenResult = $user->createToken($agent ?? 'PAT', [], $expirationMinutes);

        return $tokenResult;
    }
}
