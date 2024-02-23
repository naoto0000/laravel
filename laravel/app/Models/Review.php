<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //テーブル名
    protected $table = 'reviews';

    // 可変項目
    protected $fillable =
    [
        'member_id',
        'product_id',
        'evaluation',
        'comment',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
