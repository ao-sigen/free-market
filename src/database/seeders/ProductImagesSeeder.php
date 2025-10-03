<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            // ここに商品IDに対応する画像を設定
            $imageMap = [
                2 => 'Armani+Mens+Clock.jpg',
                3 => 'HDD+Hard+Disk.jpg',
                4 => 'iLoveIMG+d.jpg',
                5 => 'Leather+Shoes+Product+Photo.jpg',
                6 => 'Living+Room+Laptop.jpg',
                7 => 'Music+Mic+4632231.jpg',
                8 => 'Purse+fashion+pocket.jpg',
                9 => 'Tumbler+souvenir.jpg',
                10 => 'Waitress+with+Coffee+Grinder.jpg',
                11 => 'makeup.jpg',
                12 => 'other_image.jpg', // 必要に応じて修正
            ];

            $path = $imageMap[$product->id] ?? 'noimage.jpg';

            DB::table('product_images')->insert([
                'product_id' => $product->id,
                'path'       => $path,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
