<?php

namespace App\Http\Controllers\Frontend;

use App\Models\SeckillGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeckillController extends BasicController
{
    /**
     * 秒杀首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $goods = SeckillGoods::find(1);
        $user = Auth::user();

        return view('frontend.seckill', compact('goods', 'user'));
    }
}
