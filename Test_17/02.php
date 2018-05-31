<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/28
 * Time: 下午8:47
 */

/* swoole_table 内存表的使用 */

class Table
{

    private $websocket;

    public function getList($websocket, $fd)
    {
        $list = [];
        foreach ($this->websocket->userList as $key => $value) {
            $list[$key] = $value;
            var_dump($this->websocket->userList->get($key));
        }
        $websocket->push($fd, json_encode($list));
        return $list;
    }

    public function setList($frame)
    {
        $this->websocket->userList->set('x' . $frame->fd, ["gid" => $frame->fd, "fd" => $frame->fd, "info" => $frame->data]);
    }

    public function closeClient($websocket, $fd)
    {
//        $this->websocket->userList->del('x' . $fd);
    }

    public function start()
    {
        $this->websocket = new swoole_websocket_server("0.0.0.0", 9502);

        $this->websocket->set([
            "worker_num" => 2,
            "task_worker_num" => 2,
            "dispatch_mode" => 2,
            "daemonize" => false,
            "max_request" => 10,
            "debug_mode" => 1
        ]);

        $this->websocket->userList = new swoole_table(1024 * 10);

        $this->websocket->userList->column("gid", swoole_table::TYPE_STRING, 32);
        $this->websocket->userList->column("fd", swoole_table::TYPE_INT);
        $this->websocket->userList->column("info", swoole_table::TYPE_STRING, 1024 * 10);

        $this->websocket->userList->create();

        $this->websocket->on("Start",[$this,"onStart"]);
        $this->websocket->on("WorkerStart", [$this, "onWorkerStart"]);
        $this->websocket->on("message", [$this, "onMessage"]);
        $this->websocket->on("task", [$this, "onTask"]);
        $this->websocket->on("finish", [$this, "onFinish"]);
        $this->websocket->on("close", [$this, "onClose"]);
        $this->websocket->on("Request", [$this, "onRequest"]);

        $this->websocket->start();
    }

    public function onStart($server) {
        echo "[--  master_pid :" . $this->websocket->master_pid .  " --] \n";
        echo "[--  manager_pid :" . $this->websocket->manager_pid .  " --] \n";
    }

    public function onWorkerStart($server, $worker_id)
    {
//        if ($worker_id == 0) {
//            echo "worker_num = " . $this->websocket->setting['worker_num'] . "\n";
//            echo "task_worker_num = " . $this->websocket->setting['task_worker_num'] . "\n";
//        }
        echo "worker_id = " . $worker_id . "\n";
//        if ($worker_id >= $this->websocket->setting['worker_num'])
//            echo "__task_worker_start__\n";
//        else
//            echo "__workder_start__ \n";
    }

    public function onMessage($server, $frame)
    {
        echo "message: $frame->data -> task Done.\n ";
        $this->websocket->task($frame);
    }

    public function onTask($server, $task_id, $from_id, $frame)
    {
        $this->setList($frame);
        print_r($this->getList($this->websocket, $frame->fd));
        return true;
    }

    public function onFinish($server, $task_id, $data)
    {
        if ($data)
            echo "task successful! \n";
        else
            echo "task .... \n";
    }

    public function onClose($server, $fd)
    {
        $this->closeClient($server, $fd);
    }

    public function onRequest($request, $response)
    {

        $action = $request->get['action'];
        switch ($action) {
            case "stop":
                echo "commond : stop ... \n";
                $this->websocket->shutdown();
                break;
            case "rest":
                echo "commond : rest ... \n";
                $this->websocket->reload();
                break;
            default:
                echo "error commond ... \n";
                break;
        }
    }

}

$table = new Table();
$table->start();
