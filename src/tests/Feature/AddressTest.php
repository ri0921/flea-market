<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_address()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();
        $this->actingAs($profile->user)->withSession(['payment_method' => 'カード支払い']);
        $response = $this->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee($profile->post_code);
        $response->assertSee($profile->address);
        $response->assertSee($profile->building);

        $response = $this->post("/purchase/address/{$item->id}", [
            'post_code' => '123-4567',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
            'building' => '千駄ヶ谷マンション101',
        ]);
        $response = $this->followingRedirects()->get("/purchase/{$item->id}");
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区千駄ヶ谷1-2-3');
        $response->assertSee('千駄ヶ谷マンション101');

        $addressData =session('address');
        $addressData['profile_id'] = $profile->id;
        $address = Address::create($addressData);
        $response = $this->post("/purchase/{$item->id}", [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
            'address_id' => $address->id,
            'payment_method' => session('payment_method'),
        ]);
        $response->assertStatus(302);

        $purchase = Purchase::first();
        $this->assertEquals('123-4567', $purchase->address->post_code);
        $this->assertEquals('東京都渋谷区千駄ヶ谷1-2-3', $purchase->address->address);
        $this->assertEquals('千駄ヶ谷マンション101', $purchase->address->building);
    }
}
