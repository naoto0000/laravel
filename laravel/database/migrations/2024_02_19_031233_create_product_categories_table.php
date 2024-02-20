<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('カテゴリID');
            $table->string('name')->comment('カテゴリ名');
            $table->timestamps();
            $table->softDeletes();
        });

        // データ挿入
        DB::table('product_categories')->insert([
            ['name' => 'インテリア'],
            ['name' => '家電'],
            ['name' => 'ファッション'],
            ['name' => '美容'],
            ['name' => '本・雑誌'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
