<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Subcategory extends Model
{
    use SoftDeletes;

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
