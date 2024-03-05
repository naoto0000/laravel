<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MemberValue implements Rule
{
    public function passes($attribute, $value)
    {
        // データベースクエリを使用して属性の値が一意かどうかを検証する
        $count = DB::table('members')->where('id', $value)->count();
        return $count !== 0; // 値が一意であれば true を返す
    }

    public function message()
    {
        return '※値が間違っています。';
    }
}
