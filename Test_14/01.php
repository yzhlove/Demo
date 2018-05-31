<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/23
 * Time: 下午2:24
 */

/* 利用swooles搭建简易连接池 */

class PostgreSQL_Pool
{

    private $server;
    private $pdo;

    public function __construct()
    {

        $this->server = new swoole_server('127.0.0.1', '9501');
        $this->server->set([
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 1,   //连接池使用抢占模式
            'debug_mode' => 1,
            'task_worker_num' => 8
        ]);

        $this->server->on("WorkerStart", [$this, "onWorkerStart"]);
        $this->server->on("Connect", [$this, "onConnect"]);
        $this->server->on("Receive", [$this, "onReceive"]);
        $this->server->on("Close", [$this, "onClose"]);
        $this->server->on("Task", [$this, "onTask"]);
        $this->server->on("Finish", [$this, "onFinish"]);

        $this->server->start();
    }

    public function onWorkerStart($server, $worker_id)
    {

        echo "_on_worker_start_ \n";
        //判断是否为进程
        if ($worker_id >= $this->server->setting['worker_num']) {
            $this->pdo = new PDO(
                "pgsql:host=localhost;port=5432;dbname=yzh",
                "postgres", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true
            ]);
        }

    }

    public function onConnect($server, $fd, $frome_id)
    {
        echo "client {$fd} connection! \n";
    }

    public function onReceive(swoole_server $server, $fd, $from_id, $data)
    {
        $sql = [
            "sql" => "INSERT INTO users (name, email) VALUES (?, ?)",
            "param" => ["name" => "yurisa", "email"=>"yurisalove@live.com"],
            "fd" => $fd
        ];
        $server->task(json_encode($sql));
    }

    public function onClose($server, $fd, $from_id)
    {
        echo "clinet {$fd} close connection ! \n";
    }

    public function onTask($server, $task_id, $from_id, $data)
    {

//        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
//        $stmt->bindParam(1, $name);
//        $stmt->bindParam(2, $email);
//
//        $name = "live";
//        $email = "live.cn@email.com";
//        $stmt->execute();

        try {
            $sql = json_decode($data, true);
            $statement = $this->pdo->prepare($sql['sql']);
            $statement->bindParam(1,$name);
            $statement->bindParam(2,$email);

            $name = $sql['param']['name'];
            $email = $sql['param']['email'];

            $statement->execute();
            $this->server->send($sql['fd'], "Insert");
            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage() . "\n";
            return false;
        }
    }

    public function onFinish($server, $task_id, $data)
    {
        if ($data)
            echo "Insert is run successful ! \n";
        else
            echo "Insert is run failure ! \n";
    }

}

new PostgreSQL_Pool();