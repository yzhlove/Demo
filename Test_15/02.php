<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/26
 * Time: 下午8:39
 */

/* swoole 文件传输技术 */

class client_socket
{

    private $client;

    public function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

        $this->client->on("Connect", [$this, "onConnect"]);
        $this->client->on("Receive", [$this, "onReceive"]);
        $this->client->on("Close", [$this, "onCLose"]);
        $this->client->on("Error", [$this, "onError"]);

    }

    public function connect()
    {
        $status = $this->client->connect("127.0.0.1", 9501, 1);
        if (!$status) {
            echo "connect failure !\n";
            return;
        }
    }

    public function onConnect($clinet)
    {
        echo "clinet is successful ! \n";
//        $this->client->send("--help");
    }

    public function onReceive($client, $data)
    {
//        echo $data . "\n";
        fwrite(STDOUT, $data);
        echo "Input check cmd : \n";
        $msg = trim(fgets(STDIN));
        $this->client->send($msg);
    }

    public function onClose($client)
    {
        echo "client is close ... \n";
    }

    public function onError()
    {
        echo "clinet is exception ... \n";
    }

    public function isConnected()
    {
        echo "isConn: " . $this->client->isConnected() . "\n";
        return $this->client->isConnected();
    }

}

$client = new client_socket();
$client->connect();
