<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 下午4:00
 */

/* php_swoole 消息队列的使用 */

//进程池
$workers = [];
//进程数量
$worker_num = 4;

 for ($i = 0;$i < $worker_num;$i++) {

     $process = new swoole_process("doProcess",false,false);
     $process->useQueue();
     $pid = $process->start();
     $workers[] = $process;
 }

 //进程执行函数
function doProcess(swoole_process $worker) {
     $num = rand(1,10);
     echo "num = $num \n----------------------\n";
     sleep($num);
     $recv = $worker->pop();
     echo "从主进程获取到的数据: " . $recv . " --true pid " . $worker->pid . PHP_EOL;
     $worker->exit(0);
}

//从主进程向子进程添加
foreach ($workers as $pid => $process) {
     $process->push("hello $pid 子进程 " . $process->pid);
}

//等待子进程结束回收资源
for ($i = 0;$i < $worker_num;$i++) {
     $ret = swoole_process::wait();
     $pid = $ret['pid'];
     unset($workers[$pid]);
     echo "child_process exit: " . $pid . PHP_EOL;
}

echo "<End>" . "-----------------" . "<End>";