<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/22
 * Time: 下午3:38
 */

/* websocket使用 */

class TestWebSocket {

    private $web_socket;

    public function __construct() {

        $this->web_socket = new swoole_websocket_server("127.0.0.1",'8808');

        $this->web_socket->set([
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode' => 1,
            'heartbeat_check_interval' => 10
        ]);

        $this->web_socket->on("open",[$this,"onOpen"]);
        $this->web_socket->on("message",[$this,"onMessage"]);
        $this->web_socket->on("close",[$this,"onClose"]);
        $this->web_socket->on("WorkerStart",[$this,"onWorkerStart"]);
//        $this->web_socket->on("request",[$this,"onRequest"]);

        $this->web_socket->start();
    }

    public function onWorkerStart($server,$work_id) {
        echo "[------ on_work_start ------]\n";
        if ($work_id == 0) {
            $this->web_socket->tick(20 * 1000,[$this,"isConnect"]);
        }
    }

    public function isConnect() {

        $all_request = $this->web_socket->heartbeat(false);
        foreach ($all_request as $request)
            $this->web_socket->close($request);

    }

    public function onOpen(swoole_websocket_server $server,$request) {
        echo "server: client handshake success [fd:{$request->fd}]\n";
    }

    public function onMessage(swoole_websocket_server $server,$frame) {
       echo "Message : \n";
       echo "+-------------------+\n";
       echo "+ frame->fd : {$frame->fd}   \n";
       echo "+ frame->data : {$frame->data} \n";
       echo "+ opcode : {$frame->opcode} \n";
       echo "+ finish : {$frame->finish} \n";
       echo "+-------------------+\n";

        if ($frame->data == "close_client") {
            $server->send($frame->fd,"server to client is close running ... \n");
            $this->web_socket->close($frame->fd);
        }
        $server->push($frame->fd,"server : [" . strtoupper($frame->data) . "]");
    }

    public function onClose($server ,$fd) {
        echo "client [ $fd ] is close ... \n";
    }

}

new TestWebSocket();