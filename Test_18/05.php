<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/2
 * Time: 下午2:24
 */
/* 关于进程间的通信 */
/*
 * swoole进程间使用套接字通信的原理如下：
1. 父进程使用socketpair创建一对套接字
2. 创建子进程时，子进程继承了这对套接字
3. 父子进程使用系统的read，write函数对各自的套接字进行读写完成通信。
4. 对于多个子进程，父进程其实是为每个子进程创建一对套接字用于通信。
5. 子进程之间的通信，比如A向B发消息，本质是fork A进程时，A从父进程处继承了向B发消息的套接字，从而完成了向B的通信。

在通常意义来说SOCK_STREAM与SOCK_DGRAM分别用于tcp通信和udp通信，前者有序(先发先至)，可靠;后者不保证顺序及数据可靠性。但在本地套接字中，由于是本机两进程通信，不会涉及数据丢失，乱序等问题。那么这两个参数的区别在哪呢？

也就是说SOCK_STREAM是流式的，数据没有消息边界，发送方多次写入的数据，可能读取方一次就读取了。发送一次写入的数据，读取方可能分多次才读完。回到swoole意味着这种方式下，write与read的次数并不是一一对应的。你需要自己设置边界来切分消息。
SOCK_DGRAM方式，数据天然是有边界的，读写次数一定是一一对应的。回到swoole，意味着这种方式下，只要你的单条消息不超单次读写上限(默认8192字节)，就不需要自行设置边界来切分消息
 *
 * */

$process_1 = new swoole_process(function ($process) {
    $i = 1;
    while (true) {
        $msg = $process->read();
        echo "msg = " . $msg . "\n";
        echo "read $i time \n";
        $i++;
    }
},false,1);

//1 => SOCK_STREAM以流的形式读取 （数据的写入次数与读取次数并不是对等的）
//2 => SOCK_DGRAM以数据报的形式去读取 （数据的写入次数与读取次数是对等的）

$num = 10;
$process_2 = new swoole_process(function ($process) use ($process_1,$num) {

    for ($i = 0;$i < $num;$i++) {
        $process_1->write("hello $i am process_2.");
        if ($i % 5 == 0)
            sleep(1);
    }
});

$process_2->start();
$process_1->start();

swoole_process::wait();
