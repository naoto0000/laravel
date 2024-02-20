<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_subcategories', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('サブカテゴリID');
            $table->unsignedBigInteger('product_category_id')->comment('カテゴリID');
            $table->string('name')->comment('サブカテゴリ名');
            $table->timestamps();
            $table->softDeletes();
        });

        // データの挿入
        DB::table('product_subcategories')->insert([
            ['product_category_id' => 1, 'name' => '収納家具'],
            ['product_category_id' => 1, 'name' => '寝具'],
            ['product_category_id' => 1, 'name' => 'ソファ'],
            ['product_category_id' => 1, 'name' => 'ベッド'],
            ['product_category_id' => 1, 'name' => '照明'],
            ['product_category_id' => 2, 'name' => 'テレビ'],
            ['product_category_id' => 2, 'name' => '掃除機'],
            ['product_category_id' => 2, 'name' => 'エアコン'],
            ['product_category_id' => 2, 'name' => '冷蔵庫'],
            ['product_category_id' => 2, 'name' => 'レンジ'],
            ['product_category_id' => 3, 'name' => 'トップス'],
            ['product_category_id' => 3, 'name' => 'ボトム'],
            ['product_category_id' => 3, 'name' => 'ワンピース'],
            ['product_category_id' => 3, 'name' => 'ファッション小物'],
            ['product_category_id' => 3, 'name' => 'ドレス'],
            ['product_category_id' => 4, 'name' => 'ネイル'],
            ['product_category_id' => 4, 'name' => 'アロマ'],
            ['product_category_id' => 4, 'name' => 'スキンケア'],
            ['product_category_id' => 4, 'name' => '香水'],
            ['product_category_id' => 4, 'name' => 'メイク'],
            ['product_category_id' => 5, 'name' => '旅行'],
            ['product_category_id' => 5, 'name' => 'ホビー'],
            ['product_category_id' => 5, 'name' => '写真集'],
            ['product_category_id' => 5, 'name' => '小説'],
            ['product_category_id' => 5, 'name' => 'ライフスタイル'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_subcategories');
    }
}
