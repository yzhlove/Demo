<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/22
 * Time: 下午2:26
 */

/* 心跳检测 */

class TestServer {

    private $server;

    public function __construct() {

        $this->server = new swoole_server("127.0.0.1",9001);

        $this->server->set([
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_model' => 2,
            'debug_mode' => 1,
            'heartbeat_check_interval' => 5    //每隔多少时间检测一次
            //设置心跳检测超时，(默认为heartbeat_check_interval * 2),自动检测加入此项，如果手动检测，则不需要此项
//            'heartbeat_idle_time' => 20
        ]);

        $this->server->on("WorkerStart",[$this,"onWorkerStart"]);
        $this->server->on("Connect",[$this,"onConnect"]);
        $this->server->on("Receive",[$this,"onReceive"]);
        $this->server->on("Close",[$this,"onClose"]);

        $this->server->start();
    }


    public function onWorkerStart($server,$worker_id) {

        echo " onWorkerStart ... \n";

        if ($worker_id == 0) {
            $this->server->tick(10 * 1000 , function () use ($server) {

                //拿到超时请求的文件描述符
                $close_fd_all = $this->server->heartbeat(false);
                foreach ($close_fd_all as $fd)
                    $close_resource = $this->server->close($fd);    //关闭客户端连接
            });
        }

    }

    public function onConnect($server,$fd,$from_id) {
        echo "Client [$fd] is connecting .... \n";
    }

    public function onReceive(swoole_server $server,$fd,$from_id,$data) {
        echo "Get Message From Client [ $fd : $data ] \n";
    }

    public function onClose($server,$fd,$from_id) {
        echo "Client $fd close connection ... \n";
    }

}

new TestServer();