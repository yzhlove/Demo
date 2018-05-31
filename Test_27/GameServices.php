<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/10
 * Time: 上午10:50
 */

class GameServices {

//    public static $_only_cache = true;

    private $local_server_ip;
    private $local_server_port;
    private $side_server_ip;
    private $side_server_port;

    private $web_socket;

    public function __construct() {
        $this->init_ip_port();
        $this->init_service();
    }

    public function init_ip_port() {
        echo "--------------\n";
        $this->side_server_ip = "0.0.0.0";
        $this->side_server_port = 9501;
        $this->local_server_ip = "127.0.0.1";
        $this->local_server_port = 9502;
    }

    public function init_service() {
        echo "+++++++++++++++++++\n";
        $this->web_socket = new swoole_websocket_server($this->side_server_ip,$this->side_server_port);
        $this->web_socket->set([
            'worker_num' => 2,
            'reactor_num' => 2,
            'daemonize' => false,
            'max_request' => 100,
            'dispatch_mode' => 2,
            'debug_mode' => 1,
            'task_worker_num' => 2
        ]);

        echo "+++++++++++++++++++\n";

        $this->web_socket->on('WorkerStart',[$this,'onWorkerStart']);
        $this->web_socket->on('open',[$this,'onOpen']);
        $this->web_socket->on('message',[$this,'onMessage']);
        $this->web_socket->on('close',[$this,'onClose']);
        $this->web_socket->on('task',[$this,'onTask']);
        $this->web_socket->on('finish',[$this,'onFinish']);
        $this->web_socket->on('request',[$this,'onRequest']);

        echo "+++++++++++++++++++\n";
    }

    public function startService() {
//        echoLine("------ game services start ------");
        $this->web_socket->start();
    }

    public function restartService() {
//        echoLine("------ game services restart ------");
        $this->web_socket->reload();
    }

    public function stopService() {
//        echoLine("------ game services stop ------");
        $this->web_socket->shutdown();
    }

    public function onWorkerStart($server,$worker_id) {
        //数据库，缓存初始化

    }

    public function onOpen($server,$request) {
        $fd = $request->fd;
        $port = $request->server['server_port'];
        echoLine("连接成功! fd:{$fd}:port{$port}");
        info("[CLIENT_CONNECT_SUCCESS] fd:{$fd}:port{$port}");
    }

    public function onMessage($server,$fd,$from_id,$data) {

        var_dump(data);
        echoLine("接收到请求! fd:{$fd}");
        info("[RECEIVE_REQUEST] fd:{$fd}");
        $this->web_socket->task($data);

    }

    public function onClose($server,$fd) {
        $client_info = $this->server->connection_info($fd);
        $port = $client_info['server_port'];
        echoLine('断开连接，fd:' . $fd . ' port:' . $port);
        debug("[PUSH_SERVER_CLOSE]", "fd: {$fd} port: {$port}");
    }

    public function onTask($server,$task_id,$from_id,$data) {

        var_dump($data);
        echoLine("处理请求!");
        info("[PUT_REQUEST]");
        return true;
        //创造职责链
        $game = new GameHandler();
        $user = new UserHandler();
        $game->setNextHandler($user);
        //解析请求
        $request = new BaseRequest($server,$data);
        $result  = $game->HandlerRequest($request);
        return $result;
    }


    public function onFinish($server,$task_id,$data) {

        if ($data) {
            //请求处理成功
            echoLine("请求处理成功!");
        }
        //请求处理失败

    }

    public function onRequest ($request,$response) {

        $action = $request->get['act'];
        switch ($action) {
            case "stop":
                $response->end(" stop GameService !");
                $this->stopService();
                break;
            case "restart":
                $response->end(" restart GameService !");
                $this->restartService();
                break;
            default:
                $response->end("action is not found!");
                break;
        }

    }

}

$gameserver = new GameServices();
$gameserver->startService();