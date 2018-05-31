<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/21
 * Time: 下午4:56
 */

/*  异步client  */

class test_client {

    private $client;

    public function __construct() {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_ASYNC);
        $this->client->on('Connect',[$this,'onConnect']);
        $this->client->on('Receive',[$this,'onReceive']);
        $this->client->on('Close',[$this,'onCLose']);
        $this->client->on('Error',[$this,'onError']);
    }

    public function connect() {
        $fp = $this->client->connect("127.0.1",9501,1);
        if (!$fp) {
            echo "connect Server Error !\n";
            return ;
        }
    }

    public function onReceive($client,$data) {
        echo "Get Mesaage From Server: {$data} \n";
    }

    public function onConnect($client) {
        fwrite(STDOUT,"Enter Msg: ");
        swoole_event_add(STDIN,function ($fp ) {
            global $client;
            fwrite(STDOUT,"Enter Msg: ");
            $msg = trim(fgets(STDIN));
            $client->send($msg);
        });
    }

    public function onClose($client) {
        echo "client close connection ... \n";
    }

    public function onError() {

    }

    public function send($data) {
        $this->client->send($data);
    }

}

$client = new test_client();
$client->connect();

