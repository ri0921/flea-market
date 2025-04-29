<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\Address;
use App\Models\Item;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $address = Address::factory()->create();
        $item = Item::factory()->withCategories(3)->create();

        return [
            'profile_id' => $address->profile_id,
            'item_id' => $item->id,
            'address_id' => $address->id,
            'payment_method' => $this->faker->randomElement(['カード支払い', 'コンビニ払い']),
        ];
    }
}
