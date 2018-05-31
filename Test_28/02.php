<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/13
 * Time: 下午2:10
 */

/* swoole TCP分包测试 */

class server {

    protected $server;
    public function __construct() {
        $this->server = new swoole_server("0.0.0.0",9501);
        $this->server->set([
            "worker_num" => 1,
            "daemonize" => false,
            "task_worker_num" => 2,
            "max_conn" => 3000,
            "open_eof_split" => true,
            "package_eof" => "\r\n\r\n",
            "package_max_length" => 1024 * 1024 * 2
        ]);

        $this->server->on("connect",[$this,"onConnect"]);
        $this->server->on("receive",[$this,"onReceive"]);
        $this->server->on("task",[$this,"onTask"]);
        $this->server->on("finish",[$this,"onFinish"]);
        $this->server->on("close",[$this,"onClose"]);

        $this->server->start();
    }

    public function onConnect($server,$fd) {
        echo "{{$fd} is connect ... }\n";
    }

    public function onReceive($server,$fd,$reactor_id,$data) {
        echo 'from_id' . $reactor_id . '| data =' . $data . "\r\n";
        $this->server->task(['fd' => $fd,'data' => $data]);
    }

    public function onTask($server,$task_id,$reactor_id,$data) {
        $info = 'server: ' . $data['data'];
        echo 'task_id = ' . $task_id . '| data = ' . $info . "\r\n";
        $this->server->send($data['fd'],$info);
    }

    public function onFinish($server,$task_id,$data) {

    }

    public function onClose($server,$fd) {
        echo "{{$fd} is close ... }\n";
    }

}

$sv = new server();

