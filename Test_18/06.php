<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 下午3:06
 */

/* php_swoole 多进程操作 */

$url_arr = [];

for ($i = 0;$i < 10;$i++) {
    $url_arr[] = "www.baidu.com?wd=" . $i;
}

echo "start: " . date("Y-m-d H:i:s") . PHP_EOL;
$workers = [];

for ($i = 0;$i < 5;$i++) {
    //true将子进程的数据不在输出到标准屏幕上而是写入管道
    $process = new swoole_process("getContents",true);
    $process->start();
    $process->write($i);
    $workers[] = $process;
}

//主进程数据结果
foreach ($workers as $process) {
    echo $process->read() . " process_read finished \n";
}

echo "end: " . date("Y-m-d H:i:s") . PHP_EOL;

function getContents(swoole_process $worker) {
    $i = $worker->read();
    global $url_arr;
    $res_1 = executeCurl($url_arr[($i * 2)]);
    $res_2 = executeCurl($url_arr[($i * 2 + 1)]);

    echo " res_1 -> " . $res_1 ;
    echo " res_2 -> " . $res_2 ;
}

function executeCurl($url) {
    sleep(2);
    return "handler " . $url . "finished . ";
}
