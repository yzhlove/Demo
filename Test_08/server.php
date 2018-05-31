<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/19
 * Time: 下午8:50
 */
/** echo 服务器 **/
class Server {

    private $server;

    public function __construct() {
        $this->server = new swoole_server('127.0.0.1',8192);
        $this->server->set([
            'worker_num' => 4,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode' =>1
        ]);

        $this->server->on('Start',[$this,'onStart']);
        $this->server->on('Connect',[$this,'onConnect']);
        $this->server->on('Receive',[$this,'OnReceive']);
        $this->server->on('Close',[$this,'onClose']);

        $this->server->start();

    }

    public function onStart($_server) {
        echo "---> start \n";
    }

    public function onConnect($_server,$_fd,$_from_id) {
        $_server->send($_fd,"Hello {$_from_id}");
    }

    public function onReceive(swoole_server $_server,$_fd,$_from_id,$_data) {
      echo "Get message from client: {$_fd} : {$_data} \n";
    }

    public function onClose($_server,$_fd,$_from_id) {
        echo "client {$_fd} close connection \n";
    }

}

$server = new Server();