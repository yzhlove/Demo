<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/19
 * Time: 下午4:21
 */

/* 服务端 */
$ws = new swoole_websocket_server("127.0.0.1",9520);
$ws->user_c = [];
$ws->on('open',function ($ws,$request) {
   $ws->user_c[] = $request->fd;
});
$ws->on('message',function ($ws,$frame) {
    $msg = 'from ' . $frame->fd . ": {$frame->data}\n";
    foreach ($ws->user_c as $v)
        $ws->push($v,$msg);
});
$ws->on('close',function ($ws,$fd) {
    unset($ws->user_c[$fd - 1]);
});

$ws->start();

