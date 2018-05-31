<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/13
 * Time: 下午5:01
 */

require_once "BaseHandler.php";
require_once "BaseRequest.php";
require_once "GameHandler.php";
require_once "UserHandler.php";

class SwooleServerTest {

    private $server;

    public function __construct() {
        $this->server = new swoole_server("0.0.0.0",9501);

        $this->server->set([
            "worker_num" => 2,
            "daemonize" => false,
            "max_conn" => 3000,
            "max_request" => 10000,
            "task_worker_num" => 2,
            "debug_mode" => 1,
            "dispatch_mode" => 2
        ]);

        $this->server->on("connect",[$this,"onConnect"]);
        $this->server->on("receive",[$this,"onReceive"]);
        $this->server->on("close",[$this,"onClose"]);
        $this->server->on("task",[$this,"onTask"]);
        $this->server->on("finish",[$this,"onFinish"]);

        $this->server->start();
    }

    public function onConnect($server,$fd) {
        echo "{{$fd} is connect... }\n";
    }

    public function onReceive($server,$fd,$reactor_id,$data) {
        echo "onReceive is running ... \n";
        echo "data = " . $data . "\n";

        $game = new GameHandler();
        $user = new UserHandler();
        $game->setNextHandler($user);
        $game->HandlerRequest(new BaseRequest($this->server,$fd,$data));

    }

    public function onClose($server,$fd) {
        echo "{{$fd} is disconnect ... }\n";
    }

    public function onTask($server,$fd,$reactor_id,$data) {

        echo "onTask is running... \n";
        var_dump($data);
    }

    public function onFinish($server,$task_id,$data) {

    }

}

$sst = new SwooleServerTest();