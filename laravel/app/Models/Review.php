<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Review extends Model
{
    use SoftDeletes;
    use Sortable;

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
