<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/6
 * Time: 下午6:16
 */

/* onTask中push测试 */

class server{

    private $server;

    public function __construct() {

        $this->server = new swoole_websocket_server("0.0.0.0",9501);

        $this->server->set([
            'worker_num' => 2,
            'daemonize' => false,
            'dispatch_mode' => 2,
            'debug_mode' => 1,
            'task_worker_num' => 2
        ]);

        $this->server->on("open",[$this,"onOpen"]);
        $this->server->on("message",[$this,"onMessage"]);
        $this->server->on("close",[$this,"onClose"]);
        $this->server->on("task",[$this,"onTask"]);
        $this->server->on("finish",[$this,"onFinish"]);
        $this->server->on("request",[$this,"onRequest"]);
        $this->server->start();
    }

    public function onRequest($request,$response) {
        $act = $request->get['act'];
        switch ($act) {
            case "stop":
                $response->end("service stop");
                $this->server->shutdown();
                break;
            case "reload":
                $response->end("service reload");
                $this->server->reload();
                break;
        }
    }

    public function onOpen($server,$request) {
        echo $request->fd . "is connect ... \n";
    }

    public function onClose($server,$fd) {
        echo $fd . " is disconnect ... \n";
    }

    public function onMessage($server,$frame) {
        echo "task is start ... \n";
        $this->server->task($frame);
    }

    public function onTask($server,$task_id,$from_id,$info) {
        echo "task is running ... \n";
        $fd = $info->fd;
        $msg = $info->data;

        echo "fd = $fd info = $msg \n";

//        $this->server->after(2000,function ($fd) use ($server,$msg) {
//            $this->server->push($fd,"server: " . $msg);
//        });

//        $this->server->push($fd,"server: " . $msg);

        sleep(3);
        $this->server->push($fd,"server: " . $msg);

        return $fd;
    }

    public function onFinish($server,$task_id,$data) {




    }

}

$ts = new server();