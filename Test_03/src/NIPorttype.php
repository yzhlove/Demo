<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 下午4:08
 */

interface INIportype__ {
    const PORT = __CLASS__;
    function __clone();
}

class DynamicObject implements INIportype__ {

    const CONCRETE = __CLASS__;

    function __construct() {
        echo __METHOD__;
    }

    function doWork() {
        echo "This is assigntask...";
    }

    function __clone() {
        // TODO: Implement __clone() method.
    }
}

$employeeData = array("DynamicObject","Test","mar","John","Eng","Ovi","Man");
$don = $employeeData[0];
$employeeData[6] = new $don;
echo $employeeData[6]::CONCRETE;

echo "\n-------------------\n";

$employeeName = $employeeData[5];
$employeeName = clone $employeeData[6];
echo $employeeName->doWork();
echo $employeeName::PORT;

