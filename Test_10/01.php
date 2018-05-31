<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/21
 * Time: 下午3:43
 */

/*  使用task */

class test_server
{

    private $server;

    public function __construct()
    {
        //创建服务器
        $this->server = new swoole_server("127.0.0.1", 9501);
        //设置初始参数
        $this->server->set([
            'worker_num' => 16,
            'daemonize' => false,
            'max_request' => 15000,
            'dispatch' => 2,
            'debug_mode' => 1,
            'task_worker_num' => 32
        ]);
        //设置事件回掉
        $this->server->on('Start', [$this, 'onStart']);
        $this->server->on('Connect', [$this, 'onConnect']);
        $this->server->on('Receive', [$this, 'onReceive']);
        $this->server->on('Close', [$this, 'onClose']);
        $this->server->on('Task', [$this, 'onTask']);
        $this->server->on('Finish', [$this, 'onFinish']);

        //开启服务
        $this->server->start();

    }

    public function onStart($server)
    {
        echo "server staring running ... \n";
    }

    public function onConnect($server, $fd, $from_id)
    {
        echo "fd = $fd from_id = $from_id ... \n";
        //连接成功,向客户端发送一条消息
        $server->send($fd, "hi . I am is server ... -> [{$from_id}] \n");
    }

    public function onReceive(swoole_server $server, $fd, $from_id, $data)
    {
        echo "GetMessage From Client {$fd} : {$data} \n";
        //发起一个task任务
        $param = ['fd' => $fd];
        $server->task(json_encode($param));
        echo "Task is running ... \n";
    }

    //处理Task任务
    public function onTask($server, $task_id, $from_id, $data)
    {
        echo "This task {$task_id} from worker {$from_id} \n";
        echo "Data: {$data} \n";

        for ($i = 0; $i < 20; $i++) {
            sleep(1);
            echo "Task {$task_id} Handler {$i} times ... \n";
        }

        $fd = json_decode($data, true)['fd'];
        $server->send($fd, "Data in Task {$task_id} \n");
        return "Task {$task_id} is result ..,. \n";
    }

    //Task任务完成会回掉onFinish
    public function onFinish($server, $task_id, $data)
    {
        echo "Task {$task_id} finish ... \n";
        echo "Result-> {$data} ... \n";
    }

    public function onClose($server, $fd, $from_id)
    {
        echo "client {$fd} close connect ... \n";
    }

}

$server = new test_server();








