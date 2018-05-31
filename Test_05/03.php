<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/7
 * Time: 下午8:48
 */


$sid = '43d4ca21e8b954213e7e00355b2680f6704cc';

echo preg_match('/^\d+s/', $sid);
echo "\n";
$user_id = intval(explode('s', $sid, 2)[0]);

$str = explode('s', $sid, 2);
echo var_dump($str);
echo "\n";

$str = intval($str[0]);
echo $str;
echo "\n";

return $user_id;