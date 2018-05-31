<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/10
 * Time: 下午12:03
 */

//$str = '{
//    "model":"game",
//	"action":"enter",
//	"game_code":"lianliankan",
//	"data":{
//        "roomId":12386,
//		"sid":12345,
//	}
//}';

$str = '{"model":"game","action":"enter","game_code":"lianliankan","data":{"roomId":12386,"sid":"1sb73654fffa252c2ef15eb378bd5224526d"}}';

$obj = json_decode($str,true);
var_dump($obj);

echo "sid === " . $obj['data']['sid'] . "\n";

//{"model":"game","action":"enter","game_code":"lianliankan","data":{"roomId":12386,"sid":12345}}

echo "---------------------\n";
//
//$arr = [
//    "model" => "game",
//    "action" => "enter",
//    "game_code" => "lianliankan",
//    "data" => [
//        "roomId" => 12386,
//        "sid" => 12345
//    ]
//];
//
//echo json_encode($arr);
