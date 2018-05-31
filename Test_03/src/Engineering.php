<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午11:49
 */

include_once "IAcmeprototype.php";

class Engineering extends IAcmeprototype__ {

    const UNIT = "Enginerring...";
    private $development = "programming";
    private $design = "digital artwork";
    private $sysad = "system administration";

    function setDepth($_index) {
        switch ($_index) {
            case 301:
                $this->dept = $this->development;
                break;
            case 302:
                $this->dept = $this->design;
                break;
            case 303:
                $this->dept = $this->sysad;
                break;
            default:
                $this->dept = "NO NOT FIND!!!!";
                break;
        }
    }

    function getDepth() {
        return $this->dept;
    }

    function __clone() {

    }
}
