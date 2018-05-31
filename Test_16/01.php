<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/27
 * Time: 下午3:05
 */

/* 多人聊天 */

class ToMessage
{

    //消息状态（"signal"=>"单人" ，"group"=>"群组" ， "boxtip" => "弹窗消息"）
    public $message_type = "group";
    //用户ID
    public $user_id = -1;
    //房间（组） ID
    public $group_id = -1;
    //需要接收消息的用户群体
    public $other_user_id = [];
    //消息内容
    public $content = "hello";
    //消息类型
    public $content_type = "txt";
    //消息状态（true => 我向别人发 ，false => 别人向我发 ）
    public $status = "";
    //消息发送时间
    public $time = "";

}

class people_server
{

    private $server;

    public function __construct()
    {

        $this->server = new swoole_websocket_server("127.0.0.1", 9501);

        $this->server->set([
            'worker_num' => 2,
            'daemonize' => false,
            'dispatch_mode' => 2,
            'max_request' => 10,
            'debug_mode' => 1,
//            'heartbeat_check_interval' => 60
        ]);

        $this->server->on("WorkerStart", [$this, "onWorkerStart"]);
        $this->server->on("Open", [$this, "onOpen"]);
        $this->server->on("Message", [$this, "onMessage"]);
        $this->server->on("Close", [$this, "onClose"]);
        $this->server->on("Request", [$this, "onRequest"]);

        $this->server->start();
    }

    public function onWorkerStart($server, $worker_id)
    {
        echo "__on_worker_num__start__\n";
//        if ($worker_id == 0)
//            //关闭长时间不发消息的人
//            $this->server->tick(60 * 1000 ,[$this,"isConnection"]);
    }

//    public function isConnection() {
//
//        $msg = new ToMessage();
//        $msg->message_type = "boxtip";
//        $msg->content = "user to go offine";
//
//        $close_fd = $this->server->heartbeat(false);
//        foreach ($close_fd as $fd) {
//            $this->server->send($fd,json_encode($msg));
//            $this->server->close($fd);
//        }
//    }

    public function onOpen($server, $request)
    {
        echo "$request->fd is connection !\n";
    }

    public function onMessage($server, $frame)
    {
        //解析消息
        $msg = json_decode($frame->data);
        //解析群组
        $user_arr = $msg->other_user_id;
        var_dump($user_arr);
        //更改状态
        $msg->status = false;
        //转发消息
        foreach ($user_arr as $fd) {

            echo "current_fd = $fd \n";
            if ($this->server->exist($fd)) {
                var_dump(json_encode($msg));
//                $this->server->send($fd, json_encode($msg));
                $this->server->push($fd,json_encode($msg));
            }
        }
    }

    public function onClose($server, $fd)
    {
        echo "{$fd} is close connnection!\n";
    }

    public function onRequest($requet, $response)
    {
        $action = $requet->get['act'];
        echo "action = $action \n";
        switch ($action) {
            case "restart" :
                $this->server->reload();
                break;
            case "stop":
                $this->server->shutdown();
                break;
            default:
                echo "cmd is error!\n";
                break;
        }
    }

}

new people_server();
