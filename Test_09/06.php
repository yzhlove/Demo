<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 下午1:49
 */

/* 执行异步任务 */

//创建一个TCP服务器
$server = new swoole_server("127.0.0.1",9503);

//设置异步任务的工作进程数量
$server->set(['task_worker_num' => 4]);

//监听连接接入事件
$server->on("connect" , function ($server,$fd) {
    echo "client[$fd] is connect server \n";
});


//监听数据接收事件
$server->on('receive',function ($server,$fd,$from_id,$data) {

    //投递异步任务
    $task_id = $server->task($data);
    echo "Dispath AsyncTask [task_id =  $task_id] \n";

});

//处理异步任务
$server->on("task",function ($server , $task_id,$from_id,$data) {

    echo "New AsyncTask [id = $task_id] \n";
    //返回任务的执行结果
    $server->finish("$data -> ok");

});


//处理异步任务的结果
$server->on("finish",function ($server,$task_id,$data) {
    echo "AsyncTask [$task_id] Finish : $data \n";
});

$server->start();
