<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 上午9:38
 */

/*  一个简单的TCP服务器 */

//创建server对象，监听127。0。0。1：1984端口
$server = new swoole_server("127.0.0.1",1984);

//监听连接进入事件
$server->on('connect' ,function ($server ,$fd) {
    echo "fd = " . $fd . "\n";
    echo "client:connect. \n";
});

//监听数据接收事件
$server->on('receive',function ($server,$fd,$from_id,$data) {
//      echo $fd . "\n";
//      echo $from_id . "\n";
//      echo $data . "\n";
      $server->send($fd,"server: " . $data);
});

//监听连接关闭事件
$server->on('close' ,function ($server,$fd) {
    echo "client: close \n";
});

$server->start();