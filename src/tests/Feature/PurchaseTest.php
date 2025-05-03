<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Address;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function testPurchaseSuccess()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();

        $this->actingAs($profile->user)->withSession([
            'payment_method' => 'カード支払い',
            'address' => [
                'post_code' => '123-4567',
                'address' => '東京都渋谷区千駄ヶ谷1-2-3',
                'building' => '千駄ヶ谷マンション101',
            ]
        ]);

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
        $this->assertDatabaseHas('purchases', [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sold');

        $response = $this->get('/mypage?tab=buy');
        $response->assertSee($item->name);
    }

    public function testPaymentMethodSelected()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();
        $this->actingAs($profile->user);
        $response = $this->get("/purchase/{$item->id}?payment_method=カード支払い");
        $response->assertSessionHas('payment_method', 'カード支払い');
        $response->assertSee('カード支払い');
    }
}