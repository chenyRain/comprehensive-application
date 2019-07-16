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


    public function start(Request $request)
    {
        $uid = $request->input('uid');

        try {
            if (empty($uid)) {
                throw new \Exception('参数错误');
            }

            $this->jsonRes['code'] = 1;
        } catch (\Exception $e) {
            $this->jsonRes['msg'] = $e->getMessage();
        }
        return response()->json($this->jsonRes);
    }
}
