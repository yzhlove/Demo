<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/5
 * Time: 上午11:55
 */

/* 数组用例测试 */
$arr = [];

$arr[] = [1,2,3];
$arr[] = ["4"=>'four','5'=>'five'];
$arr[] = "i love";
$arr[] = [4,5,6];

var_dump($arr);

$arr[1]["hello"] = "world";

var_dump($arr);