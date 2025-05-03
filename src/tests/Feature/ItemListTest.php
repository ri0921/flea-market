<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function testAllItems()
    {
        $items = Item::factory()->withCategories(3)->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function testSoldItems()
    {
        $purchases = Purchase::factory()->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($purchases as $purchase) {
            $response->assertSee($purchase->item->name);
            $response->assertSee('Sold');
        }
    }

    public function testNotSeeOwnItems()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create(['profile_id' => $profile->id]);

        $this->actingAs($profile->user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee($item->name);
    }

}
