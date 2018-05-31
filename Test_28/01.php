<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/12
 * Time: 下午9:41
 */

/* 接口回调测试 */

class Test {

    protected $worker_id;

    public static $string = "i love you ...\n";

    public function __construct($worker_id) {
        $this->worker_id = $worker_id;
        echo "what are you doing .... \n";
    }

    public function isTest($id) {
        echo "worker = { {$this->worker_id} } is test is running ... \n";
        echo "task_id = { {$id} } is test is running ... \n";
        echo "STRING = " . Test::$string . "\n";
        sleep(10);

    }

}

class TestServer {

    private $server;
    protected $call_back;
    protected $test;

    public function __construct() {
        $this->server = new \swoole_websocket_server("0.0.0.0",9501);
        $this->server->set([
            "worker_num" => 2,
            "daemonize" => false,
            "max_request" => 100,
            "dispatch_mode" => 2,
            "debug_mode" => 1,
            "task_worker_num" => 4
        ]);
        $this->server->on("WorkerStart",[$this,"onWorkerStart"]);
        $this->server->on("open",[$this,"onOpen"]);
        $this->server->on("message",[$this,"onMessage"]);
        $this->server->on("close",[$this,"onClose"]);
        $this->server->on("request",[$this,"onRequest"]);
        $this->server->on("task",[$this,"onTask"]);
        $this->server->on("finish",[$this,"onFinish"]);
        $this->server->start();
    }

    public function onWorkerStart($server,$worker_id) {

        $this->test = new Test($worker_id);

    }

    public function onOpen($server,$request) {
        echo "$request->fd ... is connection. \n";
    }

    public function onMessage($server,$frame) {

      $this->server->task("yes");
//        $this->test->isTest($frame->fd);
    }

    public function onClose($server,$fd) {

    }

    public function onTask($server,$task_id,$from_id,$data) {

        if ($task_id == 1) {
            Test::$string = "love and you ... \n";
        }
        $this->test->isTest($task_id);
    }

    public function onFinish($server,$task_id,$data) {

        if ($data == "yes") {
            echo " yes you are is good! \n";
        }

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

$swoole_server = new TestServer();
