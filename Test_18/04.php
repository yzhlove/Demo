<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 上午11:10
 */


/* php_swoole  进程创建测试 */
$worker = [];
$worker_num = 3;

function process(swoole_process $worker)
{
    //向管道写数据
    $worker->write($worker->pid . "-" . $worker->pipe);
    echo $worker->pid . "\t" . $worker->callback . PHP_EOL;
    $worker->exit(0); //退出子进程
}

for ($i = 0; $i < $worker_num; $i++) {
    $process = new swoole_process("process");
    $pid = $process->start();
    $worker[$pid] = $process;
}

foreach ($worker as $process) {
    swoole_event_add($process->pipe, function ($pipe) use ($process) {
        echo "process->pid = " . $process->pid . " ";
        $data = $process->read();
        echo "toMsg: " . $data . PHP_EOL;
    });
}


