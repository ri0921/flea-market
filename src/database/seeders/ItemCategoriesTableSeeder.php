<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;

class ItemCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::find(1);
        $item->categories()->attach([1, 4, 5]);

        $item = Item::find(2);
        $item->categories()->attach([2, 8]);

        $item = Item::find(3);
        $item->categories()->attach(10);

        $item = Item::find(4);
        $item->categories()->attach([1, 5]);

        $item = Item::find(5);
        $item->categories()->attach([2, 7, 8]);

        $item = Item::find(6);
        $item->categories()->attach(2);

        $item = Item::find(7);
        $item->categories()->attach([1, 4]);

        $item = Item::find(8);
        $item->categories()->attach(10);

        $item = Item::find(9);
        $item->categories()->attach([3, 10]);

        $item = Item::find(10);
        $item->categories()->attach([1, 4, 5, 6]);
    }
}
