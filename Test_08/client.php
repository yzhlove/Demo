<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/19
 * Time: 下午9:05
 */
/* 客户端 */
class Client {

    private $client;

    public function __construct() {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP) ;
    }

    public function connect() {
        if (!($fp = $this->client->connect('127.0.0.1',8192,1))) {
            echo "Error: {$fp->errMsg} [{$fp->errCode}]";
        }
        $message = $this->client->recv();
        echo "Get Message From Server: {$message}\n";

        fwrite(STDOUT,"Input to text:");
        $msg = trim(fgets(STDIN));
        $this->client->send($msg);
    }

}

$client = new Client();
$client->connect();
