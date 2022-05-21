<?php

namespace Domain\Users\Commands;

use Domain\Users\Models\User;
use App\Notifications\Auth\PhoneVerificationNotification;

class CreateUserCommand
{
    public function execute(array $data)
    {
        $user = new User([
            'phone' => $data['phone'],
            // 'email' => optional($data)['email']
        ]);

        $user->newOTP();

        $user->save();

        return $user;
    }
}
