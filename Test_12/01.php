<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/22
 * Time: 上午9:42
 */

/* Timer定时器的使用 */

class TimerServer {

    private $server;

    public function __construct() {
        $this->server = new swoole_server("127.0.0.1",9588);

        $this->server->set([
            'worker_num' => 2,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,   //数据包分发策略
            'debug_mode' => 1
        ]);
        $this->server->on("WorkerStart",[$this,"onWorkerStart"]);
        $this->server->on("Connect",[$this,"onConnect"]);
        $this->server->on("Receive",[$this,"onReceive"]);
        $this->server->on("Close",[$this,"onClose"]);

        $this->server->start();
    }

    public function onWorkerStart($server,$worker_id) {

        //在workstart进程启动的时候绑定定时器
        echo "[-- onWorkerStart --] \n";

        //判断是否为task进程
        if ($worker_id >= $server->setting['worker_num'] ) {
            echo "This is tasker procress ... \n";
        }

        //只有当worker_id = 0时才添加定时器,避免重复添加
        if ($worker_id == 0) {
            $server->after(500,function () {
                echo "A is Running ... \n";
            });

            $server->after(1000,function () {
                echo " B is Running ... \n";
            });

            $id = $this->server->after(1500,function () {
               echo "C is running .... \n";
            });

            echo "ID = $id ... \n";

            $this->server->after(4000,[$this,'onTimer']);
        }

    }

    public function onConnect($server,$fd,$from_id) {
        echo "client connect : {$fd}  process_id : {$from_id} \n";
    }

    public function onReceive(swoole_server $server,$fd,$from_id,$data) {
        echo "Get Message Client -> [ ({$fd}:{$from_id}) : {$data} ]\n" ;
    }

    public function onClose($server,$fd,$from_id) {
        echo "Clinet {$fd} close process_id {$from_id} connect \n";
    }

    public function onTimer() {

        echo "ID =  ... is running ... \n";
    }

}

$timer = new TimerServer();

