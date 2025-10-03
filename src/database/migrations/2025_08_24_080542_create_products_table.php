<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 外部キーとして利用する予定なら追加
            $table->string('name');                // 商品名
            $table->integer('price');              // 価格
            $table->string('brand')->nullable();   // ブランド（NULL可にする場合）
            $table->text('description')->nullable(); // 説明
            $table->string('condition');           // 状態（例: 良好・未使用など）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
