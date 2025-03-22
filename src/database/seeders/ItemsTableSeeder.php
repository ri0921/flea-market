<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_ids = [1, 4, 5];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 1,
                'category_id' => $category_id,
                'name' => '腕時計',
                'brand' => 'EMPORIO ARMANI',
                'price' => 15000,
                'image' => 'img/watch.jpg',
                'condition' => '良好',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
            ]);
        }
        $category_ids = [2, 8];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 1,
                'category_id' => $category_id,
                'name' => 'HDD',
                'price' => 5000,
                'image' => 'img/hdd.jpg',
                'condition' => '目立った傷や汚れなし',
                'description' => '高速で信頼性の高いハードディスク',
            ]);
        }
        $category_ids = [10];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 1,
                'category_id' => $category_id,
                'name' => '玉ねぎ3束',
                'price' => 300,
                'image' => 'img/onion.jpg',
                'condition' => 'やや傷や汚れあり',
                'description' => '新鮮な玉ねぎ3束のセット',
            ]);
        }
        $category_ids = [1, 5];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 1,
                'category_id' => $category_id,
                'name' => '革靴',
                'price' => 4000,
                'image' => 'img/leather-shoes.jpg',
                'condition' => '状態が悪い',
                'description' => 'クラシックなデザインの革靴',
            ]);
        }
        $category_ids = [2, 7, 8];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 1,
                'category_id' => $category_id,
                'name' => 'ノートPC',
                'price' => 45000,
                'image' => 'img/laptop.jpg',
                'condition' => '良好',
                'description' => '高性能なノートパソコン',
            ]);
        }
        $category_ids = [2];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 2,
                'category_id' => $category_id,
                'name' => 'マイク',
                'price' => 8000,
                'image' => 'img/microphone.jpg',
                'condition' => '目立った傷や汚れなし',
                'description' => '高音質のレコーディング用マイク',
            ]);
        }
        $category_ids = [1, 4];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 2,
                'category_id' => $category_id,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'image' => 'img/shoulder-bag.jpg',
                'condition' => 'やや傷や汚れあり',
                'description' => 'おしゃれなショルダーバッグ',
            ]);
        }
        $category_ids = [10];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 3,
                'category_id' => $category_id,
                'name' => 'タンブラー',
                'price' => 500,
                'image' => 'img/tumbler.jpg',
                'condition' => '状態が悪い',
                'description' => '使いやすいタンブラー',
            ]);
        }
        $category_ids = [3, 10];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 3,
                'category_id' => $category_id,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'image' => 'img/coffee-mill.jpg',
                'condition' => '良好',
                'description' => '手動のコーヒーミル',
            ]);
        }
        $category_ids = [1, 4, 5, 6];
        foreach ($category_ids as $category_id) {
            DB::table('items')->insert([
                'profile_id' => 3,
                'category_id' => $category_id,
                'name' => 'メイクセット',
                'price' => 2500,
                'image' => 'img/makeup-set.jpg',
                'condition' => '目立った傷や汚れなし',
                'description' => '便利なメイクアップセット',
            ]);
        }
    }
}
