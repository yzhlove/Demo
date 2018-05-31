<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/20
 * Time: 下午1:36
 */

/* 定时器的使用 */

$timer_exit_id = 0;
//相当于javascript的函数 setInterval
swoole_timer_tick(1000,function ($timer_id) {
    global $timer_exit_id ;
    $timer_exit_id = $timer_id;
    echo "Hello World\n";
});

//相当于javascript的函数 setTimeout
swoole_timer_after(5000,function () {
    $timer_id = $GLOBALS['timer_exit_id'];
    echo "clear timer id => $timer_id\n";
    //根据ID清除定时器
    swoole_timer_clear($timer_id);
});
