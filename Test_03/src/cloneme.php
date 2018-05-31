<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午9:29
 */

abstract class CloneMe__ {
    public $name;
    public $prcture;
    abstract function __clone() ;
}

class Person extends CloneMe__ {

    public function __construct() {
        $this->prcture = "http://78.media.tumblr.com/8efed2442b05c1cf03e9f4168d4e4c5f/tumblr_mys8rjjV2u1r2zs3eo1_500.jpg";
        $this->name = "yurisa";
    }

    public function display() {
        echo "<img src = '".$this->prcture."' alt = '".$this->name."'/>";
    }

    function __clone() {

    }
}

$ps = new Person();
$ps->display();

$nps = clone $ps;
$nps->name = "xjj";
$nps->display();
