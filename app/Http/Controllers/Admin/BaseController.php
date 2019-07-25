<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2019/7/24
 * Time: 15:54
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $jsonRes = ['code' => 0, 'msg' => ''];
}