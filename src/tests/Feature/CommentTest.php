<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanPostComment()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();
        $response = $this->get("/item/{$item->id}");
        $this->assertEquals(0, $item->comments()->count());

        $this->actingAs($profile->user);
        $response = $this->post("/item/{$item->id}", [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
            'detail' => 'コメント内容',
        ]);
        $response = $this->followingRedirects()->get("/item/{$item->id}");
        $this->assertDatabaseHas('comments', [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
            'detail' => 'コメント内容',
        ]);
        $this->assertEquals(1, $item->fresh()->comments()->count());
    }

    public function testGuestCannotPostComment()
    {
        $item = Item::factory()->withCategories(3)->create();
        $response = $this->post("/item/{$item->id}", [
            'detail' => 'ゲストのコメント',
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'detail' => 'ゲストのテストコメント',
        ]);
    }

    public function testCommentIsRequired()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();
        $this->actingAs($profile->user);
        $response = $this->post("/item/{$item->id}", [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
            'detail' => '',
        ]);
        $response->assertSessionHasErrors(['detail']);
    }

    public function testCommentMax()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create();
        $this->actingAs($profile->user);
        $response = $this->post("/item/{$item->id}", [
            'profile_id' => $profile->id,
            'item_id' => $item->id,
            'detail' => str_repeat('あ', 256),
        ]);
        $response->assertSessionHasErrors(['detail']);
    }
}
