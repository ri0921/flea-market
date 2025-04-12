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
        DB::table('items')->insert([
            'profile_id' => 1,
            'name' => '腕時計',
            'brand' => 'EMPORIO ARMANI',
            'price' => 15000,
            'image' => 'item_img/watch.jpg',
            'condition' => '良好',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
        ]);
        DB::table('items')->insert([
            'profile_id' => 1,
            'name' => 'HDD',
            'price' => 5000,
            'image' => 'item_img/hdd.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高速で信頼性の高いハードディスク',
        ]);
        DB::table('items')->insert([
            'profile_id' => 1,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'image' => 'item_img/onion.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => '新鮮な玉ねぎ3束のセット',
        ]);
        DB::table('items')->insert([
            'profile_id' => 1,
            'name' => '革靴',
            'price' => 4000,
            'image' => 'item_img/leather-shoes.jpg',
            'condition' => '状態が悪い',
            'description' => 'クラシックなデザインの革靴',
        ]);
        DB::table('items')->insert([
            'profile_id' => 1,
            'name' => 'ノートPC',
            'price' => 45000,
            'image' => 'item_img/laptop.jpg',
            'condition' => '良好',
            'description' => '高性能なノートパソコン',
        ]);
        DB::table('items')->insert([
            'profile_id' => 2,
            'name' => 'マイク',
            'price' => 8000,
            'image' => 'item_img/microphone.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高音質のレコーディング用マイク',
        ]);
        DB::table('items')->insert([
            'profile_id' => 2,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'image' => 'item_img/shoulder-bag.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => 'おしゃれなショルダーバッグ',
        ]);
        DB::table('items')->insert([
            'profile_id' => 3,
            'name' => 'タンブラー',
            'price' => 500,
            'image' => 'item_img/tumbler.jpg',
            'condition' => '状態が悪い',
            'description' => '使いやすいタンブラー',
        ]);
        DB::table('items')->insert([
            'profile_id' => 3,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'image' => 'item_img/coffee-mill.jpg',
            'condition' => '良好',
            'description' => '手動のコーヒーミル',
        ]);
        DB::table('items')->insert([
            'profile_id' => 3,
            'name' => 'メイクセット',
            'price' => 2500,
            'image' => 'item_img/makeup-set.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '便利なメイクアップセット',
        ]);
    }
}
