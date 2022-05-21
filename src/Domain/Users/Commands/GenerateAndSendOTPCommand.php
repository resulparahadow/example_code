<?php

namespace Domain\Users\Commands;

use Domain\Users\Models\User;
use App\Notifications\Auth\PhoneVerificationNotification;

class GenerateAndSendOTPCommand
{
    public function execute(User $user)
    {
        $user->newOTP();

        // $user->notify(new PhoneVerificationNotification($user));

        $user->save();

        return $user;
    }
}
