<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/16
 * Time: 上午10:54
 */
/* PHP可变参数设置 */

function test(...$string) {

     $str = '';
     foreach ($string as $s)
         $str .= ' <' . $s . '> ';

     echo $str;
//     return $transform($str);
}

$res = test("I","Love","You");

echo "\n";