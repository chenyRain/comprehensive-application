<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\BasicController;

class SeckillController extends BasicController
{
    /**
     * 秒杀首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $goods = Goods::find(1);
        return view('frontend.seckill', compact('goods'));
    }
}
