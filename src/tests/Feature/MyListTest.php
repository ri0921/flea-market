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
        $likedItem = Item::factory()->withCategories(3)->create([
            'name' => 'いいね',
        ]);
        Like::create([
                'profile_id' => $profile->id,
                'item_id' => $likedItem->id,
        ]);
        $unlikedItem = Item::factory()->withCategories(3)->create([
            'name' => '表示しない',
        ]);

        $this->actingAs($profile->user);
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSeeText('いいね');
        $response->assertDontSeeText('表示しない');
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
        $item = Item::factory()->withCategories(3)->create([
            'profile_id' => $profile->id,
            'name' => '表示しない',
        ]);

        $this->actingAs($profile->user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSeeText('表示しない');
    }

    public function testGuestInMyList()
    {
        $items = collect([
            Item::factory()->withCategories(3)->create(['name' => 'アイテムA']),
            Item::factory()->withCategories(3)->create(['name' => 'アイテムB']),
            Item::factory()->withCategories(3)->create(['name' => 'アイテムC']),
        ]);
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertDontSeeText($item->name);
        }
    }
}