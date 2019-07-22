<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2018/12/8
 * Time: 17:43
 */

namespace App\Http\Controllers\Frontend;


use Illuminate\Support\Facades\Redis;

class PublishController extends BasicController
{
    public function index()
    {
        Redis::publish('test-channel', json_encode(['test' => '啊啊四大']));
    }
}