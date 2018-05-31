<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午10:31
 */

include_once "IPrototype.php";

class MaleProto extends IPrototype__ {

    const GENDER = "MALE";

    public $mated;

    public function __construct() {

        echo "[info:".__CLASS__.__METHOD__."]\n";

        $this->eye_color_ = "red";
        $this->wing_beat_ = "200";
        $this->unit_eyes_ = "760";
    }

    function __clone() {
    }
}
