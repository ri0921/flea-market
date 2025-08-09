<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            DB::table('profiles')->insert([
                'user_id' => $user->id,
                'name' => $user->name,
                'post_code' => $faker->regexify('\\d{3}-\\d{4}'),
                'address' => $faker->prefecture() . $faker->city() . $faker->streetAddress(),
                'building' => $faker->secondaryAddress(),
            ]);
        }
    }
}
