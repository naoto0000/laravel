<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Administer extends Authenticatable
{
    use SoftDeletes;
    //テーブル名
    protected $table = 'administers';

    // 可変項目
    protected $fillable =
    [
        'name',
        'login_id',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
