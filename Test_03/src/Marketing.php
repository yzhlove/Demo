<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午11:25
 */

//接口实现
include_once "IAcmeprototype.php";

class Marking extends IAcmeprototype__ {

    const UNIT = "Markting";
    private $sales = "sales";
    private $promotion = "promotion";
    private $startegic = "startegic planning";

    function setDepth($_index) {
        switch ($_index) {
            case 101:
                $this->dept = $this->sales;
                break;
            case 102:
                $this->dept = $this->promotion;
                break;
            case 103:
                $this->startegic = $this->startegic;
                break;
            default:
                $this->dept = "No !!!!!";
                break;
        }
    }

    function getDepth() {
        return $this->dept;
    }

    function __clone() {

    }
}

