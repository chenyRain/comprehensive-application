<?php

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $table = 'admin_users'; // 设置表名

    public $timestamps = false; // 关闭自动维护 created_at 和 updated_at 字段


    /**
     * 通过用户名查找单条数据
     * @param string $username
     */
    public static function findByUserName($username)
    {
        return self::select('id', 'name', 'password')
            ->where('name', $username)
            ->first();
    }


    /**
     * 根据用户名判断用户是否存在
     * @param $username
     * @return mixed
     */
    public static function isExistsByUserName($username)
    {
        return self::where('name', $username)->exists();
    }
}
