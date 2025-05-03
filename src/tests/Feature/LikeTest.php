<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Profile;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function testLike()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();

        $response = $this->get("/item/{$item->id}");
        $this->assertEquals(0, $item->likes()->count());
        $response->assertSee('unlike.svg');

        $this->actingAs($profile->user);
        $response = $this->followingRedirects()->get("/item/{$item->id}/like");
        $this->assertDatabaseHas('likes', [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
        ]);
        $this->assertEquals(1, $item->fresh()->likes()->count());
        $response->assertSee('like.svg');

        $response = $this->followingRedirects()->get("/item/{$item->id}/unlike");
        $this->assertDatabaseMissing('likes', [
        'profile_id' => $profile->id,
        'item_id' => $item->id,
        ]);
        $this->assertEquals(0, $item->fresh()->likes()->count());
    }
}
