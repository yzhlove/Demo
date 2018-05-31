<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/27
 * Time: 上午10:27
 */

/* PHP 字符串函数测试 */

$string = "hello world singnal";
$str = "world";

echo "strpos = " . strpos($string,$str) . "\n";
echo "strstr = " . strstr($string,$str) . "\n";

echo "--------";

$string = "--show 01.php";
$str = "--show";
$index = strpos($string,$str);
$length = $index + strlen($str);

echo "index = $index length = $length \n";

$filename = substr($string,$length);
echo "filename [$filename] \n";
echo "filename [" . trim($filename) . "] \n";

echo strpos("12345" ,"6") . "-- \n";

if (($index = strpos("12 345 " ,"12")) > -1)
    echo " $index yes \n";
else
    echo " $index no \n";