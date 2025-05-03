<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Like;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function testItemDetail()
    {
        $item = Item::factory()->withCategories(3)->create();
        $profile = Profile::factory()->create();
        $like = Like::create([
            'profile_id' => $profile->id,
            'item_id' => $item->id,
        ]);
        $comment = Comment::create([
            'profile_id' => $profile->id,
            'item_id' => $item->id,
            'detail' => 'Great item!',
        ]);

        $response = $this->get('/item/'. $item->id);
        $response->assertStatus(200);
        $response->assertSee($item->image);
        $response->assertSee($item->name);
        $response->assertSee($item->brand);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->likes_count);
        $response->assertSee($item->comments_count);
        $response->assertSee($item->description);
        foreach ($item->categories as $category) {
            $response->assertSee($category->content);
        }
        $response->assertSee($item->condition);
        $response->assertSee($profile->image);
        $response->assertSee($profile->name);
        $response->assertSee($comment->detail);
    }
}
