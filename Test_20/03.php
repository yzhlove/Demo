<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/4
 * Time: 上午10:33
 */

/* PHP 字符串测试 */
$str = "110011";

echo substr($str,-2,2);

//json编码
$json_arr = [
    "msgId" => "110000",
    "time" => time()
];

$message = [
    "msgId" => "120101",
    "info" => [
        "myLevel" => 15000,"otLevel" => 15001
    ]];

echo "\n";

//$json_list = json_encode($json_arr);
//var_dump($json_list);
//
//$json_object = json_encode($json_arr,JSON_FORCE_OBJECT);
//var_dump($json_object);

var_dump(json_encode($message));
var_dump(json_encode($message,JSON_FORCE_OBJECT));

