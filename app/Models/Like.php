<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'like'; // 设置表名

    public $timestamps = false; // 关闭自动维护 created_at 和 updated_at 字段
}
