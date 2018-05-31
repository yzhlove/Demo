<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/8
 * Time: 上午9:34
 */

//swoole 多端监听技术

class server_port {

    private $server;
    private $server_ip;
    private $server_port;
    //多址监听
    private $server_side_ip;
    private $server_side_port;


    public function __construct() {
        $this->init();
        $this->server = new swoole_server($this->server_ip,$this->server_port);

        $this->server->set([
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 100,
            'dispatch_mode' => 2,
            'debug_mode' => 1
        ]);

        $this->server->on('connect',[$this,"onConnect"]);
        $this->server->on('receive',[$this,"onReceive"]);
        $this->server->on('close',[$this,"onClose"]);

        $this->server->addListener($this->server_side_ip,$this->server_side_port,SWOOLE_SOCK_TCP);
        $this->server->start();
    }

    public function init() {
        $this->server_port = 9501;
        $this->server_ip = "127.0.0.1";

        $this->server_side_port = 9502;
        $this->server_side_ip = "0.0.0.0";
    }

    public function onConnect($server,$fd) {

        //判断IP以及端口
        $conn_info = $this->server->connection_info($fd);
        var_dump($conn_info);
        echo "[{$fd}] is connection successful!";
    }

    public function onReceive($server,$fd,$from_id,$data) {

        $conn_info = $this->server->connection_info($fd,$from_id);

        if ($conn_info['remote_ip'] == "127.0.0.1") {

            foreach ($this->server->connections as $fd) {
                $this->server->send($fd,$conn_info['server_port'] . ": " . $data);
            }
        } elseif ($conn_info['remote_ip'] == "192.168.111.21") {
            foreach ($this->server->connections as $fd) {
                $this->server->send($fd,$conn_info['server_port'] . "-> " . $data);
            }
        }
        if (strpos($data,"stop") > -1) {
            $this->server->shutdown();
            echo "stop server ... \n";
        }
    }

    public function onClose($server,$fd) {
        echo "[{$fd} is disconnection!] \n";
    }
}

$sp = new server_port();
