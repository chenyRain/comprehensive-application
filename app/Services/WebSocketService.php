<?php

namespace App\Services;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 * @see https://wiki.swoole.com/wiki/page/400.html
 */
class WebSocketService implements WebSocketHandlerInterface
{
    /**
     * 声明没有参数的构造函数
     * WebSocketService constructor.
     */
    public function __construct()
    {

    }


    /**
     * 监听WebSocket连接打开事件，连接成功后，触发open事件
     * @param \swoole_websocket_server $server
     * @param \swoole_http_request $request
     */
    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        // 处理用户ID
        $uid = intval(ltrim($request->server['request_uri'],'/'));

        try {
            // 绑定fd
            Redis::zadd('chatlist', $uid, $request->fd);

            // 获取所有FD
            $list = Redis::zrange('chatlist', 0, -1);

            // 处理用户信息，用于列表
            $user_list = array();
            foreach ($list as $key => $value) {
                // 获取对应用户ID
                $user_id = Redis::zscore('chatlist', $value);
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
                'message' => '欢迎 '. $name . ' 来到聊天室',
                'list' => $user_list
            ];

            // 推送给所有人
            foreach ($list as $value) {
                $server->push($value, json_encode($msg));
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage(), array('uid' => $uid));
        }
    }


    /**
     * 监听WebSocket消息事件，客户端向服务端发送消息时，触发message事件
     * @param \swoole_websocket_server $server
     * @param \swoole_websocket_frame $frame
     */
    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        try {
            // 获取对应用户ID
            $uid = Redis::zscore('chatlist', $frame->fd);
            // 获取用户信息
            $name = Redis::hget('userinfo', 'name:' . $uid);
            // 获取所有FD
            $list = Redis::zrange('chatlist', 0, -1);

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
            Log::info($e->getMessage(), array('fd' => $frame->fd));
        }
    }


    /**
     * 监听WebSocket连接关闭事件
     * @param \swoole_websocket_server $server
     * @param $fd
     * @param $reactorId
     */
    public function onClose(\swoole_websocket_server $server, $fd, $reactorId)
    {
        try {
            // 获取对应用户ID
            $uid = Redis::zscore('chatlist', $fd);
            // 删除集合中用户信息
            Redis::zrem('chatlist', $fd);

            // 获取所有FD
            $list = Redis::zrange('chatlist', 0, -1);

            // 处理用户信息，用于列表
            $user_list = array();
            foreach ($list as $key => $value) {
                // 获取对应用户ID
                $user_id = Redis::zscore('chatlist', $value);
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
            Log::info($e->getMessage(), array('uid' => $uid));
        }
    }
}