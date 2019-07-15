<?php

namespace App\Services;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;


/**
 * @see https://wiki.swoole.com/wiki/page/400.html
 */
class WebSocketService implements WebSocketHandlerInterface
{
    /**
     * 实例化的对象
     * @var
     */
    public $obj;

    /**
     * URL参数
     * @var array
     */
    public $data = [];

    /**
     * 声明没有参数的构造函数
     * WebSocketService constructor.
     */
    public function __construct()
    {

    }


    /**
     * 实例化指定对象类
     * @param Request $request
     */
    private function setObj($request)
    {
        // 处理参数
        $query = trim($request->server['request_uri'],'/');
        $params = explode('/', $query);
        $params_arr = [];
        foreach ($params as $item) {
            $params_arr[] = explode(':', $item);
        }

        $this->data = array_column($params_arr, 1, 0);

        if ($this->data['type'] == 1) {
            $this->obj = new ChatSocketService;
        } elseif ($this->data['type'] == 2) {
            $this->obj = new SeckillSocketService;
        } else {
            exit;
        }
    }


    /**
     * 监听WebSocket连接打开事件，连接成功后，触发open事件
     * @param \swoole_websocket_server $server
     * @param \swoole_http_request $request
     */
    public function onOpen(Server $server, Request $request)
    {
        $this->setObj($request);
        $this->obj->open($server, $request, $this->data);
    }


    /**
     * 监听WebSocket消息事件，客户端向服务端发送消息时，触发message事件
     * @param \swoole_websocket_server $server
     * @param \swoole_websocket_frame $frame
     */
    public function onMessage(Server $server, Frame $frame)
    {
        $this->obj->message($server, $frame);
    }


    /**
     * 监听WebSocket连接关闭事件
     * @param \swoole_websocket_server $server
     * @param $fd
     * @param $reactorId
     */
    public function onClose(Server $server, $fd, $reactorId)
    {
        $this->obj->close($server, $fd);
    }
}