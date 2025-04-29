<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;
use App\Models\Profile;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $profile = Profile::factory()->create();

        return [
            'profile_id' => $profile->id,
            'post_code' => $profile->post_code,
            'address' => $profile->address,
            'building' => $profile->building,
        ];
    }
}
