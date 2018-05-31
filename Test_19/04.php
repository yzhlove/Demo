<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/3
 * Time: 上午11:29
 */


/* php_swoole  回调函数 */

class TestServer_2 {

    private $server;

    public $BaseProcess;
    public $MasterToManager;
    public $ManagerToWorker;

    public function __construct() {

        $this->server = new swoole_server("127.0.0.1",9501,SWOOLE_PROCESS,SWOOLE_SOCK_TCP);

        //在交互进程中放入一个数据方便测试
        $this->BaseProcess = "I am base process !";

        //以下回掉方法按照被调用的顺序组织

        //1.首先启动Master进程
        $this->server->on("start",function (swoole_server $server) {

            echo "=============[ start  ]=============\n";
            //打印交互数据
            echo "server->BaseProcess = " . $this->BaseProcess . PHP_EOL;
            //修改交互数据
            $this->BaseProcess = "I am changed By master ." . PHP_EOL;
            //在Master进程写入一些数据传递给Manager进程
            $this->MasterToManager = "Hello Manager , I am master ." . PHP_EOL;
            echo "=============[Endstart]=============\n\n";

        });

        //2.Master fork Manager进程
        $this->server->on("ManagerStart",function (swoole_server $server) {
            echo "=============[ ManagerStart  ]=============\n";
            // 打印，然后修改交互进程中写入的数据
            echo "server->BaseProcess = ".$this->BaseProcess.PHP_EOL;
            $this->BaseProcess = "I'm changed by manager.";
            // 打印，然后修改在Master进程中写入的数据
            echo "server->MasterToManager = ".$this->MasterToManager.PHP_EOL;
            $this->MasterToManager = "This value has changed in manager.";

            // 写入传递给Worker进程的数据
            $this->ManagerToWorker = "Hello worker, I'm manager.";
            echo "=============[EndManagerStart]=============\n\n";
        });

        //3.Manager fork Worker 进程
        $this->server->on("WorkerStart",function (swoole_server $server,$worker_id) {
            echo "=============[ WorkerStart  ]=============\n";
            echo "work_id *** " . $worker_id . '===> '. $server->setting['worker_num']."\n";
            echo "server->BaseProcess = ".$this->BaseProcess.PHP_EOL;

            // 打印，并修改Master写入给Manager的数据
            echo "server->MasterToManager = ".$this->MasterToManager.PHP_EOL;
            $this->MasterToManager = "This value has changed in worker.";

            // 打印，并修改Manager传递给Worker进程的数据
            echo "server->ManagerToWorker = ".$this->ManagerToWorker.PHP_EOL;
            $this->ManagerToWorker = "This value is changed in worker.";
            echo "=============[EndWorkerStart]=============\n\n";
        });

        //4.正常结束server,首先结束worker进程
        $this->server->on("WorkerStop",function (swoole_server $server,$worker_id) {
            echo "=============[ ** WorkerStop ** ]=============\n";
            //分别打印之前的数据
            echo "server->ManagerToWorker = " . $this->ManagerToWorker . PHP_EOL;
            echo "server->MasterToManager = " . $this->MasterToManager . PHP_EOL;
            echo "server->BaseProcess = " . $this->BaseProcess . PHP_EOL;
            echo "=============[EndWorkerStop]=============\n\n";
        });

        //5.紧接着结束Manager进程
        $this->server->on("ManagerStop",function (swoole_server $server) {
            echo "=============[ ** ManagerStop ** ]=============\n";
            echo "server->ManagerToWorker = " . $this->ManagerToWorker . PHP_EOL;
            echo "server->MasterToManager = " . $this->MasterToManager . PHP_EOL;
            echo "server->BaseProcess = " . $this->BaseProcess . PHP_EOL;
            echo "=============[EndManagerStop]=============\n\n";
        });

        //6.最后回收Master进程
        $this->server->on("shutdown",function (swoole_server $server) {
            echo "=============[ ** MasterStop ** ]=============\n";
            echo "server->ManagerToWorker = " . $this->ManagerToWorker . PHP_EOL;
            echo "server->MasterToManager = " . $this->MasterToManager . PHP_EOL;
            echo "server->BaseProcess = " . $this->BaseProcess . PHP_EOL;
            echo "=============[ MasterStop  ]=============\n\n";
        });

        $this->server->on("connect",function ($server,$fd) {
            echo "<---------- connect { {$fd} }---------->" . PHP_EOL;
        });

        $this->server->on("receive",function ($server,$fd,$from_id,$data) {
            echo "msg = $data ";
            if (stripos($data,"shutdown") > -1) {
                $this->server->shutdown();
            }
            $server->send($fd,"server: " . $data);
        });

        $this->server->on("close",function ($server,$fd) {
            echo "<---------- close { {$fd} }---------->" . PHP_EOL;
        });

        $this->server->set([
            //使用守护进程模式运行的时候加上"log_file,pid_file选项"
            "daemonize" => false,
//            "log_file" => __DIR__ . "/swoole_log.log",
//            "pid_file" => __DIR__ . "/swoole_pid.log",
            "worker_num" => 4
        ]);

        $this->server->start();
    }

}

$ts = new TestServer_2();

/*
Master进程被启动。
Manager进程被Master进程fork出来。
Worker进程被Manager进程fork出来。
MasterStart被回调。
ManangerStart被回调。
WorkerStart被回调。

结论：
父进程fork出子进程的时候，子进程会拷贝一份父进程的所有数据。
各个进程之间的数据一般情况下是不共享内存的。
 *
 * */
