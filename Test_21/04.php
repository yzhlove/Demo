<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/4
 * Time: 下午7:46
 */

/* 嵌套数组 测试 */

$str = '{
"method":"LianLianKan:init",
"version":"1.0",
"timestamp":12345678,
"game_code":"lianliankan",
"data":{
        "room_id":100,
        "sid":"ssssssssssss"
       }
}';


var_dump($str);

$object_arr = json_decode($str,true);

var_dump($object_arr);