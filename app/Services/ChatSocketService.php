<?php
/**
 * Created by PhpStorm.
 * User: karthus
 * Date: 2019/7/12
 * Time: 11:00
 */

namespace App\Services;

use App\Models\WebsocketLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;


class ChatSocketService
{
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
            Redis::zadd('chat_list', $uid, $request->fd);

            // 获取所有FD
            $list = Redis::zrange('chat_list', 0, -1);

            // 处理用户信息，用于列表
            $user_list = array();
            foreach ($list as $key => $value) {
                // 获取对应用户ID
                $user_id = Redis::zscore('chat_list', $value);
                // 获取用户信息
                $username = Redis::hget('userinfo', 'name:' . $user_id);

                $user_list[$key]['uid'] = $uid;
                $user_list[$key]['name'] = $username;
            }

            // 获取用户信息
            $name = Redis::hget('userinfo', 'name:' . $uid);

            // 推送进入聊天室通知的信息
            $msg = [
                'type' => 'open',
                'name' => $name,
                'uid' => $uid,
                'message' => '欢迎 <b class="chat-notice">'. $name . '</b>  来到聊天室',
                'list' => $user_list
            ];

            // 推送给所有人
            foreach ($list as $value) {
                $server->push($value, json_encode($msg));
            }
        } catch (\Exception $e) {
            WebsocketLog::insert(['type' => 1, 'content' => var_export(['msg' => $e->getMessage(), 'uid' => $uid],true), 'ctime' => Carbon::now()]);
        }
    }


    /**
     * 监听WebSocket消息事件，客户端向服务端发送消息时，触发message事件
     * @param $server
     * @param $frame
     */
    public function message($server, $frame)
    {
        try {
            // 获取对应用户ID
            $uid = Redis::zscore('chat_list', $frame->fd);
            // 获取用户信息
            $name = Redis::hget('userinfo', 'name:' . $uid);
            // 获取所有FD
            $list = Redis::zrange('chat_list', 0, -1);

            // 过滤数据
            $data = strip_tags($frame->data);
            $data = htmlspecialchars($data);

            $msg = [
                'type' => 'message',
                'message' => $data,
                'name' => $name,
                'uid' => $uid
            ];

            // 推送给所有人
            foreach ($list as $value) {
                $server->push($value, json_encode($msg));
            }
        } catch (\Exception $e) {
            WebsocketLog::insert(['type' => 1, 'content' => var_export(['msg' => $e->getMessage(), 'uid' => $uid, 'fd' => $frame->fd], true), 'ctime' => Carbon::now()]);
        }
    }


    /**
     * 监听WebSocket连接关闭事件
     * @param $server
     * @param $fd
     * @param $reactorId
     */
    public function close($server, $fd)
    {
        try {
            // 获取对应用户ID
            $uid = Redis::zscore('chat_list', $fd);
            // 删除集合中用户信息
            Redis::zrem('chat_list', $fd);

            // 获取所有FD
            $list = Redis::zrange('chat_list', 0, -1);

            // 处理用户信息，用于列表
            $user_list = array();
            foreach ($list as $key => $value) {
                // 获取对应用户ID
                $user_id = Redis::zscore('chat_list', $value);
                // 获取用户信息
                $username = Redis::hget('userinfo', 'name:' . $user_id);

                $user_list[$key]['uid'] = $uid;
                $user_list[$key]['name'] = $username;
            }

            // 获取用户信息
            $name = Redis::hget('userinfo', 'name:' . $uid);

            $msg = [
                'type' => 'close',
                'uid' => $uid,
                'message' => $name." 离开了聊天室",
                'list' => $user_list
            ];

            // 推送给所有人
            foreach ($list as $value) {
                $server->push($value, json_encode($msg));
            }
        } catch (\Exception $e) {
            WebsocketLog::insert(['type' => 1, 'content' => var_export(['msg' => $e->getMessage(), 'uid' => $uid], true), 'ctime' => Carbon::now()]);
        }
    }
}