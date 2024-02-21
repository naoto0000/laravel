<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //テーブル名
    protected $table = 'product_subcategories';

    // 可変項目
    protected $fillable =
    [
        'product_category_id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
