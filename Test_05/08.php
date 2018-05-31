<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/12
 * Time: 上午10:19
 */

//测试IP

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    echo " remote_ip =  " . $remote_ip . PHP_EOL;
    $forwarded_for = $this->headers();
}

?>

<form action="" method="get">
    <input type="submit" value="submit"/>
</form>





