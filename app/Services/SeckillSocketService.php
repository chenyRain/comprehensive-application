<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2019/7/12
 * Time: 15:12
 */

namespace App\Services;

use App\Models\WebsocketLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;


class SeckillSocketService
{
    const ACTIVITY_GOING = 9; // 活动准备时间
    const IN_ACTIVITY = 29; // 活动持续时间

    /**
     * 监听WebSocket连接打开事件，连接成功后，触发open事件
     * @param $server
     * @param $request
     * @param $data
     */
    public function open($server, $request, $data)
    {
        // 处理用户ID
        $uid = isset($data['uid']) ? $data['uid'] : 0;

        try {
            if (empty($uid)) {
                throw new \Exception('用户ID不能为空');
            }

            // 绑定fd
            Redis::zadd('seckill_list', $uid, $request->fd);

        } catch (\Exception $e) {
            WebsocketLog::insert(['type' => 1, 'content' => var_export(['msg' => $e->getMessage(), 'uid' => $uid],true), 'ctime' => Carbon::now()]);
        }
    }


    /**
     * 监听WebSocket消息事件，客户端向服务端发送消息时，触发message事件
     * @param  $server
     * @param  $frame
     */
    public function message($server, $frame)
    {
        try {
            // 获取所有FD
            $list = Redis::zrange('seckill_list', 0, -1);

            $msg = [
                'activity_going_time' => 0,
                'activity_in_time' => 0
            ];

            // 推送给所有人
            foreach ($list as $value) {
                $server->push($value, json_encode($msg));
            }

        } catch (\Exception $e) {
            WebsocketLog::insert(['type' => 2, 'content' => var_export(['msg' => $e->getMessage(), 'fd' => $frame->fd], true), 'ctime' => Carbon::now()]);
        }
    }


    /**
     * 监听WebSocket连接关闭事件
     * @param $server
     * @param $fd
     */
    public function close($server, $fd)
    {
        // 删除集合中用户信息
        Redis::zrem('seckill_list', $fd);
    }
}