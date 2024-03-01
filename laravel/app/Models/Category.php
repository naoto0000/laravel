<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use Sortable;

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

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'product_category_id');
    }

    public $sortable = ['id', 'created_at'];

}
