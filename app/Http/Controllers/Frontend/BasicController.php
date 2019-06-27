<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2019/6/26
 * Time: 10:00
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;

class BasicController extends Controller
{
    protected $offset = 10; // 分页数

    protected $jsonRes = ['code' => 0, 'msg' => ''];
}