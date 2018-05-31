<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/4
 * Time: 上午9:59
 */

/*  PHP json嵌套解析  */

$data = '{"msgId":110001,"info":{"level":2000,"roomId":19,"rid":10}}';

$obj = json_decode($data);
var_dump($obj);

echo "romId = " . $obj->info->roomId . ">\n";

echo "\n=========================\n";

$obj2 = json_decode($data,true);
var_dump($obj2);

$data = json_encode($obj);
echo "data = " . $data . PHP_EOL;

$data2 = json_encode($obj2);
echo "data = " . $data2 . PHP_EOL;

$tm = time();
echo $tm;