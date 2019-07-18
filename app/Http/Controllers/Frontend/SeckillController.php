<?php

namespace App\Http\Controllers\Frontend;

use App\Models\SeckillGoods;
use App\Services\SeckillService;
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

        $template = 'frontend.seckill';
        if ($user->is_super == 1) {
            $template = 'frontend.set-seckill';
        }
        return view($template, compact('goods', 'user'));
    }


    /**
     * 开启活动,设置参数
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request)
    {
        $data = $request->input();
        try {
            $service = new SeckillService;
            $service->setSeckill($data);

            $this->jsonRes['code'] = 1;
        } catch (\Exception $e) {
            $this->jsonRes['msg'] = $e->getMessage();
        }
        return response()->json($this->jsonRes);
    }


    /**
     * 立即抢购
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy()
    {
        try {
            $service = new SeckillService;
            $service->buy();

            $this->jsonRes['code'] = 1;
            $this->jsonRes['msg'] = "恭喜你，抢到了苹果一个";
        } catch (\Exception $e) {
            $this->jsonRes['msg'] = $e->getMessage();
        }
        return response()->json($this->jsonRes);
    }


    /**
     * 抢到用户名单
     * @return \Illuminate\Http\JsonResponse
     */
    public function result()
    {
        $service = new SeckillService;
        $result = $service->result();

        $this->jsonRes['code'] = 1;
        $this->jsonRes['result'] = $result;
        return response()->json($this->jsonRes);
    }
}
