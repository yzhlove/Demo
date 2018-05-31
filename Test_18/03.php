<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 上午10:54
 */

/* 关于swoole  创建进程的测试 */
$workers = [];
$worker_num = 3; //创建的进程数

//进程处理函数
function process(swoole_process $proc) {
    //pid 子进程的ID
    //pipe管道的文件描述符
    $proc->write($proc->pid . " - " . $proc->pipe);
    echo $proc->pid , "\t" , $proc->callback . PHP_EOL;
}
for ($i = 0;$i < $worker_num;$i++) {
    $process = new swoole_process("process");
    $pid = $process->start();
    $workers[$pid] = $process;
    //子进程也会包含此事件
    swoole_event_add($process->pipe,function ($pipe) use ($process) {
        echo "process->pid = " . $process->pid . " ";
        $data = $process->read();
        echo "RECV: " . $data.PHP_EOL;
    });
}



