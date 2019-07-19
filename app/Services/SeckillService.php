<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2019/7/12
 * Time: 15:12
 */

namespace App\Services;


use App\Models\SeckillGoods;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class SeckillService
{
    /**
     * 设置秒杀队列
     * @throws \Exception
     */
    public function setSeckill(array $data)
    {
        if (empty($data['datetime_picker_end'])) {
            throw new \Exception('结束时间不能为空');
        }
        if (empty($data['datetime_picker_start'])) {
            throw new \Exception('开始时间不能为空');
        }
        if (empty($data['redis_max_user'])) {
            throw new \Exception('队列允许人数不能为空');
        }
        if (empty($data['repertory'])) {
            throw new \Exception('库存不能为空');
        }
        SeckillGoods::updateGoods(1, $data);
        $goodsInfo = SeckillGoods::find(1);

        // 未开启活动直接返回
        if ($data['status'] == 0) {
            return;
        }
        Redis::command('del', ['user_list', 'success']); // 初始化

        // 将商品添加到队列
        for ($i = 1; $i <= $goodsInfo->repertory; $i++) {
            Redis::lpush($goodsInfo->redis_key, $i); // 从链表头部添加商品
        }

        // 设置过期时间
        if (! $this->setExpireTime($goodsInfo)) {
            throw new \Exception('设置商品队列过期时间失败');
        }
    }


    /**
     * 设置过期时间
     * @param $goods
     */
    private function setExpireTime($goods)
    {
        $expireTime = (strtotime($goods->end_time) - time()) + 5;
        return Redis::expire($goods->redis_key, $expireTime);
    }


    /**
     * 立即抢购
     * @throws \Exception
     */
    public function buy()
    {
        $user = Auth::user();
        if (empty($user->id)) {
            throw new \Exception('用户ID为空');
        }

        $goodsInfo = SeckillGoods::find(1);

        // 是否超出队列允许最大人数
        if (Redis::llen('user_list') > $goodsInfo->redis_max_user) {
            throw new \Exception('抱歉，被抢光了');
        }

        // 是否单人多次抢购
        $userAll = Redis::hkeys('success');
        if (in_array($user->id, $userAll)) {
            throw new \Exception('每人只能抢购一次');
        }

        Redis::lpush('user_list', $user->id); // 将用户加入队列

        // 从链表的头部删除一个元素，返回删除的元素,因为pop操作是原子性，即使很多用户同时到达，也是依次执行
        $goodsNumber = Redis::lpop($goodsInfo->redis_key);
        if (empty($goodsNumber)) {
            throw new \Exception('抱歉，被抢光了');
        }

        Redis::hset('success', $user->id, $user->name); // 添加抢到的用户名称
    }


    /**
     * 抢购结束结果
     * @return mixed
     */
    public function result()
    {
        $goods = SeckillGoods::find(1);
        $goods->repertory = Redis::llen($goods->redis_key);
        $goods->status = 0;
        $goods->save();

        $result['repertory'] = $goods->repertory;
        $result['success'] = Redis::hvals('success');
        return $result;
    }
}