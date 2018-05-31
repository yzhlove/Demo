<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/8
 * Time: 下午9:04
 */

//swoole 热重启技术

class reload_server {

    private $server;

    public function __construct() {
        $this->server = new swoole_server("0.0.0.0",9501);

        $this->server->set([
            'worker_num' => 2,
            'daemonize' => false,
            'max_request' => 100,
            'dispatch_mode' => 2,
            'debug_mode' > 1
        ]);

        $this->server->on("start",[$this,'onStart']);
        $this->server->on("WorkerStart",[$this,'onWorkerStart']);
        $this->server->on("connect",[$this,'onConnect']);
        $this->server->on("receive",[$this,'onReceive']);
        $this->server->on("close",[$this,'onClose']);

        $this->server->start();
    }

    public function onStart($server) {
        echo "onstart \n";
//        swoole_set_process_name("reload_timer");
//        cli_set_process_title("reload_timer");
    }

    public function onWorkerStart($server,$worker_id) {
        //引入PHP文件
        require_once "reload_page.php";
        Test();
    }

    public function onConnect($server,$fd) {
        echo "client { {$fd} }  connect \n";
    }

    public function onReceive($server,$fd,$reactor_id,$data) {
        echo "getMessage: [{$fd}]" . $data . "\n";
        if ($data = "stop")
            $this->server->shutdown();
    }

    public function onClose($server,$fd,$reactor_id) {
        echo "{$fd} is disconnect!\n";
    }

}

$rs = new reload_server();