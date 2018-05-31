<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/3
 * Time: 上午9:52
 */

/* swoole 揭秘 */

/*
 * start方法执行之后：
 * 1.当前进程退出（守护进程模式），fork出Master进程，并触发OnMasterStart事件
 * 2.Master进程启动之后，fork出Manage进程，并触发OnManageStart事件
 * 3.Manage进程启动之后,fork出Worker进程，并触发OnWorkerStart事件
 *
 * 一个最基础的swoole_server至少需要3个进程（Master,Manage,Worker）进程，且[Master,Manage]进程各一个，
 * [worker]进程可以有多个
 *
 *
 * 双核CPU：
 * 1条Master进程
 * 1条Manage进程
 * 4条Worker进程
 *
 * */

class TestServer_1 {

    private $server ;

    public function __construct() {

        /*
         * SWOOLE_PROCESS 多进程模式(默认)
         * SWOOLE_SOCK_TCP TCP协议
         *
         *  */
        $this->server = new swoole_server("127.0.0.1",9001,SWOOLE_PROCESS,SWOOLE_SOCK_TCP);

        $this->server->set([
            //使用守护进程模式运行的时候加上"log_file,pid_file选项"
            "daemonize" => true,
            "log_file" => __DIR__ . "/swoole_log.log",
            "pid_file" => __DIR__ . "/swoole_pid.log",
            "reactor_num" => 2,
            "worker_num" => 4
        ]);

        $this->server->on("connect",function ($server,$fd) {
            echo "$fd : connect successful!\n";
        });

        $this->server->on("receive",function ($server,$fd,$from_id,$data) {
            echo "msg = $data ";
            if (stripos($data,"shutdown") > -1) {
                $this->server->shutdown();
            }
            $server->send($fd,"server: " . $data);
        });

        $this->server->on("close",function ($server,$fd) {
            echo "{$fd} is close connection ... \n";
        });
        $this->server->start();
    }

}

$ts = new TestServer_1();

/*
 * 工作模式：
 * 1.Client 主动Connect的时候，Client实际上与Master（进程）中的某个（Reactor线程）发生了连接。
 * 2.当TCP三次握手成功之后，由这个Reactor线程将连接成功的消息高速Manage进程，再由Manage进程转交给Worker进程。
 * 3.在这个Worker进程中触发OnConnect方法。
 * 4.当Client向Server发送一个数据包的时候，首先收到数据包的是Reactor线程，同时Reactor线程会完成组包，再将组好的包交给Manage进程，然后在由Manage进程转交给Worker进程。
 * 5.此时Worker进程触发OnReceive事件。
 * 6.如果在Worker中做业务处理的时候，然后在用send方法将数据发回到客户端的时候，数据则回沿着这个路径逆流而上。
 *
 * */