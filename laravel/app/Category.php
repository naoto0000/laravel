<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //テーブル名
    protected $table = 'product_categories';

    // 可変項目
    protected $fillable =
    [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
