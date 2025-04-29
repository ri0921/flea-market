<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'name' => $this->faker->firstName,
            'image' => $this->faker->imageUrl(640, 480). '.jpg',
            'post_code' => $this->faker->regexify('\d{3}-\d{4}'),
            'address' => $this->faker->address,
            'building' => $this->faker->optional()->secondaryAddress,
        ];
    }
}
