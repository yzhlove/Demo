<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/29
 * Time: 下午8:49
 */

/* php-swoole  多进程初试 */

$test = "test";

function doProcess(swoole_process $worker) {

    global $test;

    var_dump($test);
    var_dump($worker);
    echo "PID " . $worker->pid . PHP_EOL;
    sleep(10);
}

//通过匿名函数创建进程

$process = new swoole_process(function (swoole_process $worker) use ($test) {

    echo "这是匿名函数创建的" . PHP_EOL;
    var_dump($test);

});

//start 函数创建之后会返回子进程的pid
$pid = $process->start();
echo "pid: " . $pid . PHP_EOL;


//传入callback创建进程
$process = new swoole_process("doProcess");
$pid = $process->start();
echo "process_pid = " . $pid . "\n";
swoole_process::wait();
echo " 结束了" . PHP_EOL;

/*
 *
object(Swoole\Process)#3 (6) {
  ["pipe"]=>
  int(5)
  ["callback"]=>
  string(9) "doProcess"
  ["msgQueueId"]=>
  NULL
  ["msgQueueKey"]=>
  NULL
  ["pid"]=>
  int(684)
  ["id"]=>
  NULL
}
 * */