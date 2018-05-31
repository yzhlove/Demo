<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/13
 * Time: 下午3:04
 */

/* 客户端测试 */
$client = new swoole_client(SWOOLE_SOCK_TCP);
$ret = $client->connect('127.0.0.1',9501,5);

for ($i = 0;$i < 50;$i++) {
    $data = 'data' . sprintf('%05d',$i) . "\r\n\r\n";
    $result = $client->send($data);
    if ($result)
        echo $data;
}

$data = $client->recv();
if ($data)
    echo $data;

