<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;

class MyPageTest extends TestCase
{
    use RefreshDatabase;

    public function testMyPage()
    {
        $profile = Profile::factory()->create();
        $item = Item::factory()->withCategories(3)->create(['profile_id' => $profile->id]);
        $purchase = Purchase::factory()->create(['profile_id' => $profile->id]);

        $this->actingAs($profile->user);
        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee($profile->image);
        $response->assertSee($profile->name);
        $response->assertSee($item->name);

        $response = $this->get('/mypage?tab=sell');
        $response->assertSee($item->name);

        $response = $this->get('/mypage?tab=buy');
        $response->assertSee($purchase->item->name);
    }

    public function testEditProfile()
    {
        $profile = Profile::factory()->create();
        $this->actingAs($profile->user);
        $response = $this->get('/mypage/profile');
        $response->assertSee($profile->image);
        $response->assertSee($profile->name);
        $response->assertSee($profile->post_code);
        $response->assertSee($profile->address);
        $response->assertSee($profile->building);
    }
}