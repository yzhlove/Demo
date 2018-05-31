<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 下午8:08
 */

/*  swoole_php 测试 */

class TestServer {

    private $server;

    public function __construct() {

        $this->server = new swoole_server("127.0.0.1",1234);

        $this->server->on("connect",[$this,"on_connect"]);
        $this->server->on("receive",[$this,"on_receive"]);
        $this->server->on("close",[$this,"on_close"]);

        $this->server->start();
    }

    public function on_connect($server,$fd) {
        echo "[{$fd}] is connect ... \n";
    }

    public function on_receive($server,$fd,$from_id,$data) {
        echo "===================================\n";
        echo $data;
        echo "===================================\n";
        $request = explode("\r\n",$data) ;
        if (stripos($request[0],"hello.php")) {
            echo "hello\n";
            $this->server->send($fd,"your need to hello php! \n");
        } else if (stripos($request[0],"world.php")) {
            echo "world\n";
            $this->server->send($fd,"your need to world php");
        } else {
            echo "404\n";
            $this->server->send("404 not found.");
        }
    }

    public function on_close($server,$fd) {
        echo "[{$fd}] is closing ... \n";
    }
}

$tcpserver = new TestServer();