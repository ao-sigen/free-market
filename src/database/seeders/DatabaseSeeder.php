<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 先に条件テーブルを埋める
        $this->call([
            ConditionSeeder::class,
        ]);

        // 次にカテゴリーなど
        $this->call([
            CategoriesTableSeeder::class,
        ]);

        // 最後に products を作る
        $this->call([
            ProductsTableSeeder::class,
        ]);
    }
}

