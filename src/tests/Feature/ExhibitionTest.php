<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Category;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_exhibit_item()
    {
        $profile = Profile::factory()->create();
        $this->actingAs($profile->user);
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $imagePath = public_path('img/watch.jpg');
        $uploadedImage = new UploadedFile(
            $imagePath,
            'watch.jpg',
            mime_content_type($imagePath),
            null,
            true
        );
        $response = $this->post('/sell', [
            'image' => $uploadedImage,
            'categories' => [$category1->id, $category2->id],
            'condition' => '良好',
            'name' => 'サンプル商品',
            'brand' => 'サンプルブランド',
            'description' => 'これはサンプルの商品です。',
            'price' => '1000',
        ]);
        $response->assertRedirect('/mypage?tab=sell');

        $this->assertDatabaseHas('items', [
            'condition' => '良好',
            'name' => 'サンプル商品',
            'brand' => 'サンプルブランド',
            'description' => 'これはサンプルの商品です。',
            'price' => '1000.00',
        ]);
        $item = \App\Models\Item::latest()->first();
        $this->assertDatabaseHas('item_categories', [
            'item_id' => $item->id,
            'category_id' => $category1->id,
        ]);
        $this->assertDatabaseHas('item_categories', [
            'item_id' => $item->id,
            'category_id' => $category2->id,
        ]);
    }
}
