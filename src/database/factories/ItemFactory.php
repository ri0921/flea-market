<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Category;

class ItemFactory extends Factory
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
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'price' => $this->faker->numberBetween(1, 50000),
            'image' => $this->faker->imageUrl(640, 480). '.jpg',
            'condition' => $this->faker->randomElement(['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い']),
            'description' => $this->faker->paragraph(),
        ];
    }

    public function withCategories($categoryCount = 3)
    {
        return $this->afterCreating(function (Item $item) use ($categoryCount) {
            $categories = Category::inRandomOrder()->take($categoryCount)->pluck('id');
            $item->categories()->attach($categories);
        });
    }

}