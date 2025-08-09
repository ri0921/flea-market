<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $users = [
            [
                'name' => 'user01',
                'email' => 'user01@example.com',
                'password' => Hash::make('user01pass'),
                'email_verified_at' => $now,
            ],
            [
                'name' => 'user02',
                'email' => 'user02@example.com',
                'password' => Hash::make('user02pass'),
                'email_verified_at' => $now,
            ],
            [
                'name' => 'user03',
                'email' => 'user03@example.com',
                'password' => Hash::make('user03pass'),
                'email_verified_at' => $now,
            ]
        ];
        DB::table('users')->insert($users);
    }
}
