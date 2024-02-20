<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueValue implements Rule
{
    public function passes($category, $value)
    {
        // データベースクエリを使用して属性の値が一意かどうかを検証する
        $count = DB::table('product_categories')->where($category, $value)->count();
        return $count === 0; // 値が一意であれば true を返す
    }

    public function message()
    {
        return '値が間違っています。';
    }
}
