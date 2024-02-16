<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //テーブル名
    protected $table = 'members';

    // 可変項目
    protected $fillable = 
    [
        'name_sei',
        'name_mei',
        'nickname',
        'gender',
        'password',
        'email',
        'auth_code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
