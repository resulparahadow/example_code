<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Clients\Models\Client;
use Domain\Users\Models\User;

class ClientsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'phone'      => '62007125',
            ]
        ];

        foreach ($data as $key => $userData) {
            $user = User::create($userData);
            $tokenResult = $user->createToken($agent ?? 'PAT', [], config('sanctum.expiration'));
            dump($user,$tokenResult->plainTextToken,'----------------------');
        }
    }
}
