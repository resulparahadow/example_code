<?php

namespace Database\Seeders;

use Domain\Staffs\Models\Staff;
use Illuminate\Database\Seeder;

class StaffsSeeder extends Seeder
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
                'role'         => 'admin',
                'firstname'    => 'Mohamed',
                'lastname'     => 'Hojaev',
                'email'        => 'admin1@asman.com',
                'password'     => \Hash::make(123123),
            ],
            [
                'role'         => 'admin',
                'firstname'    => 'Resul',
                'lastname'     => 'Parahadow',
                'email'        => 'admin2@asman.com',
                'password'     => \Hash::make(123123),
            ]
        ];

        foreach ($data as $key => $staff) {
            Staff::create($staff);
        }
    }
}
