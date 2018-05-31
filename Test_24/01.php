<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/6
 * Time: 下午2:43
 */

/* php yeild 使用 */

function getArguments() {
    for ($i = 0;$i < 5;$i++)
        yield $i;
}

$Argument = getArguments();

foreach ($Argument as $i) {
    echo "i = $i \n";
}

var_dump($Argument);


