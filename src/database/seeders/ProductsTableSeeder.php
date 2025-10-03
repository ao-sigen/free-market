<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['腕時計', 15000, 'Rolax', 'スタイリッシュなデザインのメンズ腕時計', 1, 'Armani+Mens+Clock.jpg'],
            ['HDD', 5000, '西芝', '高速で信頼性の高いハードディスク', 2, 'HDD+Hard+Disk.jpg'],
            ['玉ねぎ3束', 300, null, '新鮮な玉ねぎ3束のセット', 3, 'iLoveIMG+d.jpg'],
            ['革靴', 4000, null, 'クラシックなデザインの革靴', 4, 'Leather+Shoes+Product+Photo.jpg'],
            ['ノートPC', 45000, null, '高性能なノートパソコン', 1, 'Living+Room+Laptop.jpg'],
            ['マイク', 8000, null, '高音質のレコーディング用マイク', 2, 'Music+Mic+4632231.jpg'],
            ['ショルダーバッグ', 3500, null, 'おしゃれなショルダーバッグ', 3, 'Purse+fashion+pocket.jpg'],
            ['タンブラー', 500, null, '使いやすいタンブラー', 4, 'Tumbler+souvenir.jpg'],
            ['コーヒーミル', 4000, 'Starbacks', '手動のコーヒーミル', 1, 'Waitress+with+Coffee+Grinder.jpg'],
            ['メイクセット', 2500, null, '便利なメイクアップセット', 2, 'makeup.jpg'],
        ];

        foreach ($products as $item) {
            // products テーブルに挿入
            $productId = DB::table('products')->insertGetId([
                'user_id' => 1,
                'name' => $item[0],
                'price' => $item[1],
                'brand' => $item[2],
                'description' => $item[3],
                'condition_id' => $item[4],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // product_images テーブルに挿入
            DB::table('product_images')->insert([
                'product_id' => $productId,
                'path' => 'products/' . $item[5],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
