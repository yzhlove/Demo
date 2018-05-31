<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 下午5:39
 */

/* swoole 有趣的小例子 */

/* swoole 之 tcp_server */

class amusing_server {

    private $server;
    public function __construct() {
        $server = new swoole_server("127.0.0.1",1234);
        $server->on("connect",function ($server,$fd) {
            echo "[{$fd}] client connect \n";
            $server->send($fd,"connection successful!\n");
        });

        $server->on("receive",function ($server,$fd,$from_id,$data) {
            echo "message: " . $data . "\n";
            $server->tick(1000,function ($fd) use ($server,$data){
                $server->send($fd,"client to : " . $data);
            });
        });

        $server->on("close",function ($server,$fd) {
            echo "[{$fd}] is close ... \n";
        });
        $server->start();
    }
}

$amusing = new amusing_server();

