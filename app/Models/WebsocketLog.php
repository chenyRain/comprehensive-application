<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsocketLog extends Model
{
    protected $table = 'websocket_log'; // 设置表名

    public $timestamps = false; // 关闭自动维护 created_at 和 updated_at 字段
}
