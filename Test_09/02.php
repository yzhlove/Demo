<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 上午10:11
 */

/* 创建UDP服务器 */

//创建server对象，监听端口，设置类型为SWOOLE_OSCK_UDP
$server = new swoole_server('127.0.0.1',9502,SWOOLE_PROCESS,SWOOLE_UDP);

//监听数据接收事件
$server->on('Packet',function ($server,$data,$client_info) {
    $server->sendto($client_info['address'] , $client_info['port'],"server: " . $data);
    var_dump($client_info);
});

//启动服务
$server->start();