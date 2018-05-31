<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/7
 * Time: 下午4:33
 */

$str = "123";
$str = base64_encode($str);
echo $str . "\n";
$str = base64_decode($str);
echo $str . "\n";
