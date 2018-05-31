<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/15
 * Time: 下午3:43
 */

//array_splice函数测试

$arr_1 = ['a'=>'red','b'=>'green','c'=>'tomato','d'=>'blue'];
$arr_2 = ['one' => 'hello','two'=>'world','three'=>'shift'];

$result = array_splice($arr_1,1,2,$arr_2);
print_r($result);
echo "\n";
print_r($arr_1);
