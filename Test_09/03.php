<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 上午10:26
 */

/* 创建一个简单的web服务器 */

$http = new swoole_http_server('0.0.0.0',9505);
$http->on('request',function ($request,$response) {

    var_dump($request,$request) ;

    $response->header("Content-Type","text/html;charset=utf-8");
    $response->end("<h1> Hello Swoole . " . date("Y-m-d H:m:s") . "</h1>");
});

$http->start();