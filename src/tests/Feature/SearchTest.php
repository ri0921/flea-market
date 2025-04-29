<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;


class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search()
    {
        Item::factory()->withCategories(3)->create([
            'name' => 'Apple Juice']);
        Item::factory()->withCategories(3)->create([
            'name' => 'Orange Juice']);
        Item::factory()->withCategories(3)->create([
            'name' => 'Pineapple']);
        
        $response = $this->get('/search?tab=suggest&keyword=Apple');
        $response->assertStatus(200);
        $response->assertSee('Apple Juice');
        $response->assertSee('Pineapple');
        $response->assertDontSee('Orange Juice');
    }

    public function test_search_in_my_list()
    {
        Item::factory()->withCategories(3)->create([
            'name' => 'Apple Juice']);
        Item::factory()->withCategories(3)->create([
            'name' => 'Orange Juice']);
        Item::factory()->withCategories(3)->create([
            'name' => 'Pineapple']);
        
        $response = $this->get('/search?tab=suggest&keyword=Apple');
        $response->assertStatus(200);
        $response->assertSee('Apple Juice');
        $response->assertSee('Pineapple');
        $response->assertDontSee('Orange Juice');

        $response = $this->get('/search?tab=mylist&keyword=Apple');
        $response->assertStatus(200);
        $this->assertEquals('Apple', request('keyword'));
    }
}
