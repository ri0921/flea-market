<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function testLikeItems()
    {
        $profile = Profile::factory()->create();
        $items = Item::factory()->withCategories(3)->count(5)->create();
        $likedItems = $items->take(3);
        foreach ($likedItems as $item) {
            Like::create([
                'profile_id' => $profile->id,
                'item_id' => $item->id,
            ]);
        }
        $unlikedItems = $items->skip(3);

        $this->actingAs($profile->user);
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        foreach ($likedItems as $item) {
            $response->assertSee($item->name);
        }
        foreach ($unlikedItems as $item) {
            $response->assertDontSee($item->name);
        }
    }

    public function testSoldItems()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();
        $likedItem = Like::create([
                        'profile_id' => $profile->id,
                        'item_id' => $item->id,
                    ]);
        $purchase = Purchase::factory()->create(['item_id' => $item->id,]);

        $this->actingAs($profile->user);
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    public function testNotSeeOwnItems()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create(['profile_id' => $profile->id]);
        Like::create([
            'profile_id' => $profile->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($profile->user);
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee($item->name);
    }

    public function testGuestInMyList()
    {
        $profile = Profile::factory()->create();
        $items = Item::factory()->withCategories(3)->count(3)->create();
        foreach ($items as $item) {
            Like::create([
                'profile_id' => $profile->id,
                'item_id' => $item->id,
            ]);
        }
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee($item->name);
    }
}