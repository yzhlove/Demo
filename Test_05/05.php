<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/8
 * Time: 下午5:45
 */

function one($type = true) {
    echo "one" . "\n";
    return $type;
}

function two($type = true) {
    echo "two" . "\n";
    return $type;
}

if (one() || two()) {
    echo "yes" . "\n";
}



