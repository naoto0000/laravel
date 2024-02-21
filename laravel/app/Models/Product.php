<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //テーブル名
    protected $table = 'products';

    // 可変項目
    protected $fillable =
    [
        'member_id',
        'product_category_id',
        'product_subcategory_id',
        'name',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'product_content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
