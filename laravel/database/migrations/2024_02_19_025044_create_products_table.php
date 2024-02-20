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
            $table->bigIncrements('id')->comment('スレッドID');
            $table->integer('member_id')->comment('会員ID');
            $table->integer('product_category_id')->comment('カテゴリID');
            $table->integer('product_subcategory_id')->comment('サブカテゴリID');
            $table->string('name')->comment('商品名');
            $table->string('image_1')->nullable()->comment('写真１');
            $table->string('image_2')->nullable()->comment('写真２');
            $table->string('image_3')->nullable()->comment('写真３');
            $table->string('image_4')->nullable()->comment('写真４');
            $table->text('product_content')->comment('商品説明');
            $table->timestamps();
            $table->softDeletes();
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
