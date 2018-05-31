<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/9
 * Time: 下午3:17
 */

//多址监听测试

class Address_Server {

    private $server;
    public $user_arr = [];

    public $local_ip;
    public $local_port;
    public $side_ip;
    public $side_port;

    public $class_member_value = "what fuck \n";

    public function __construct() {

        $this->server = new swoole_websocket_server($this->local_ip,$this->local_port);
        $this->server->set([
            "worker_num" => 2,
            "daemonize" => false,
            "max_request" => 100,
            "dispatch_mode" => 2,
            "debug_mode" => 1,
            "task_worker_num" => 4
        ]);

        $this->server->on("start",[$this,"onStart"]);
        $this->server->on("WorkerStart",[$this,"onWorkerStart"]);
        $this->server->on("open",[$this,"onOpen"]);
        $this->server->on("message",[$this,"onMessage"]);
        $this->server->on("close",[$this,"onClose"]);
        $this->server->on("request",[$this,"onRequest"]);
        $this->server->on("task",[$this,"onTask"]);
        $this->server->on("finish",[$this,"onFinish"]);

        //多址监听
        $this->server->start();

    }

    public function onStart($server) {
        echo "start ... \n";
        swoole_set_process_name("address_test");
    }


    public function onWorkerStart($server,$worker_id) {

        echo "----------------------------\n";
        echo $this->class_member_value;
        $this->class_member_value = "what are you doing [" . $worker_id ."] \n";
        echo $this->class_member_value;
        echo "----------------------------\n";
    }

    public function onOpen($server,$request) {

    }

    public function onMessage($server,$frame) {

    }

    public function onClose($server,$fd) {

    }

    public function onTask($server,$task_id,$from_id,$data) {

    }

    public function onFinish($server,$task_id,$data) {

    }

    public function onRequest($request,$response) {
        $action = $request->get['act'];
        switch ($action) {
            case "stop":
                $this->server->shutdown();
                break;
        }
    }


}

$as = new Address_Server();