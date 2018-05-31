<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/7
 * Time: 下午4:04
 */

function checkSum($string)
{
    if (strlen($string) < 2) {
        return false;
    }
    $chars = str_split(substr($string, 0, -2));
    $total = 0;
    foreach ($chars as $char) {
        $total += ord($char);
    }
    echo "total = " . $total . "\n";
    $sum = sprintf('%02x', $total % 255);
    echo "sum = " . $sum . "\n";
    return substr($string, -2) == $sum;
}

$string = "3c0ef3978d5bc0df198a3c01bf3aa84e55";

$str = checkSum($string);
echo $str;

$str = substr($string,0,-2);
echo $str;

$chars = str_split($str);
echo var_dump($chars);

$test = ord($chars[0]);
$test = ord('A');
echo $test;

