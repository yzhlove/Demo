<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午11:33
 */

include_once "IAcmeprototype.php";

class ManageMent extends IAcmeprototype__ {

    const UNIT = "ManageMent";

    private $research = "research";
    private $plan = "planning";
    private $operations = "operations";

    function setDepth($_index) {
        switch ($_index) {
            case 201:
                    $this->dept = $this->research;
                break;
            case 202:
                    $this->dept = $this->plan;
                break;
            case 203:
                    $this->dept = $this->operations;
                break;
            default:
                    $this->dept = "No Search !!!!";
                break;
        }
    }

    function getDepth() {
        return $this->dept;
    }

    function __clone() {

    }
}
