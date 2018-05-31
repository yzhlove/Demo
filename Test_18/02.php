<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 上午10:02
 */

/* php_swoole 管道通信例子 */

echo "startTime: ". date("H:i:s") . PHP_EOL;

//进程池
$worker = [];
//创建进程的数量
$worker_num = 3;

$url = [
    "www.baidu.com",
    "www.360.cn",
    "www.blog.diligentyang.com"
];

$result = [];

for ($i = 0;$i < $worker_num;$i++) {
    $process = new swoole_process("doProcess");             //创建新的进程
    $pid = $process->start();                               //启动进程，返回pid
    $process->write($i);     //向管道写入当前i的值
    $worker[$pid] = $process;   //放入进程池中
}

//创建进程执行函数
function doProcess(swoole_process $worker) {
    global $url;
    $i = $worker->read();
    echo $url[$i] . PHP_EOL;
    $res = curlTest($url[$i],10 - $i * 2);
    $worker->write("pid: ". $worker->pid . " res: " . $res . PHP_EOL);
    echo "写入信息： pid: " . $worker->pid . " res: " . $res . " /*" . $worker->callback . "*/" . PHP_EOL;
}

//添加进程执行动作
foreach ($worker as $process) {

    //使用异步非阻塞模式
    swoole_event_add($process->pipe,function ($pipe) use ($process,$result) {
        $data = $process->read();
        echo "process->read: " . $data . PHP_EOL;
        $result[] = $data;
    });

    //使用同步阻塞模式
//    $data = $process->read();
//    echo "process->read : " . $data . PHP_EOL;
//    $result[] = $data;
}

function curlTest($url,$stime) {
    sleep($stime);
    return "handler " . $url . " finished";
}

for ($i = 0;$i < $worker_num;$i++) {
    $ret = swoole_process::wait();
    $pid = $ret['pid'];
    unset($worker[$pid]);
    echo "Worker Exit , PID = " . $pid . PHP_EOL;
}

var_dump($result);
echo "结束" . PHP_EOL;
echo "endTime: " . date("H:i:s") . PHP_EOL;