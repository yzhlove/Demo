<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/25
 * Time: 下午1:33
 */

/* 数据库连接池-客户端 */

class PostgreSQL_Client {

    private $client;
    private $i;
    private $time;

    public function __construct() {

        $this->client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_ASYNC);

        $this->client->on("Connect",[$this,"onConnect"]);
        $this->client->on("Receive",[$this,"onReceive"]);
        $this->client->on("Close",[$this,"onClose"]);
        $this->client->on("Error",[$this,"onError"]);
    }

    public function connect() {
        $fp = $this->client->connect("127.0.0.1",9501,1);
        if (!$fp) {
            echo "Error: {$fp->errMsg()} : [{$fp->errCode}] \n";
        }
    }

    public function onReceive($client,$data) {
        ++ $this->i;
        if ($this->i >= 10000) {
            echo "User Time: ". (time() - $this->time);
            exit(0);
        } else
            $client->send("Get");
    }

    public function onConnect($client) {
        $client->send("Get");
        $this->time = time();
    }

    public function onClose($client) {
        echo "Client close connection \n";
    }

    public function onError() {

    }

    public function send($data) {
        $this->client->send($data);
    }

    public function isConnected() {
        return $this->client->isConnected();
    }
}

$client = new PostgreSQL_Client();
$client->connect();

