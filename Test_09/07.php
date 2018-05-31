<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 下午5:27
 */

/* 同步TCP客户端 */

$client = new swoole_client(SWOOLE_SOCK_TCP);

//连接到服务器
if (!$client->connect('127.0.0.1',1984,0.5))
    die("connect failed");

//向服务器发送数据
if (!$client->send('what fuck'))
    die("send fail");

//从服务器接收数据
$data = $client->recv();
if (!$data)
    die('recv failed');

echo $data;
$client->close();