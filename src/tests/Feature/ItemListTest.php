<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Profile;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items()
    {
        $items = Item::factory()->withCategories(3)->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_sold_items()
    {
        $purchases = Purchase::factory()->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($purchases as $purchase) {
            $response->assertSee($purchase->item->name);
            $response->assertSee('Sold');
        }
    }

    public function test_not_see_own_items()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create(['profile_id' => $profile->id]);

        $this->actingAs($profile->user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee($item->name);
    }

}
