<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 上午10:41
 */

/*  创建一个简单的websocket服务器 */

//创建websocket服务器对象,监听端口127。0。0。1：9588端口
$websocket = new swoole_websocket_server('127.0.0.1',9588);

//监听websocket连接的打开事件
//客户端与服务器握手成功会触发onOpen事件，表示连接就绪。
$websocket->on('open',function ($ws,$request) {
    var_dump($request->fd,$request->get,$request->server);
    $ws->push($request->fd,"Hello World Wsoole\n");
});

//监听websocket消息事件
//客户端向服务器发送信息时，服务器端会触发onMessage事件回调
//服务器端可以调用push向某个客户端(使用fd区分)发送消息
$websocket->on('message',function ($ws,$frame) {
    echo "Message: {$frame->data}\n";
    $ws->push($frame->fd,"server : <-- {$frame->data} -->");
});

//监听websocket连接关闭事件
$websocket->on('close',function ($ws,$fd) {
    echo "client-{$fd} is closed\n";
});

$websocket->start();