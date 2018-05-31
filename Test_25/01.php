<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/9
 * Time: 上午10:21
 */

// uniqid函数测试

$str = "_php";
echo uniqid() . PHP_EOL;
echo uniqid() . PHP_EOL;

$src = 1 . uniqid(mt_rand()) . microtime();
echo "str = $src";
echo PHP_EOL;
echo md5($src);