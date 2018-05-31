<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 下午5:41
 */

/* 创建异步TCP客户端 */

$client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_ASYNC);

//注册连接成功回掉
$client->on('connect',function ($cli) {
    $cli->send('Hello World');
});

//注册数据接收回掉
$client->on('receive',function ($cli,$data) {
    echo "Receive: " . $data . "\n";
    $cli->close();
});

//注册连接失败回掉
$client->on('error' ,function ($cli) {
    echo "Connect Failed";
});

//注册连接关闭回掉
$client->on('close',function ($cli) {
    echo "Connection close";
});

//发起连接
$client->connect('127.0.0.1',1984,0.5);