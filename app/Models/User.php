<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * @param array $data
     * @return bool|mixed
     */
    public static function register($data = array())
    {
        if (empty($data)) {
            return false;
        }
        $model = new User();
        $model->name = $data['name'];
        $model->password = bcrypt($data['password']);
        return $model->save() ? $model->id : false;
    }
}
