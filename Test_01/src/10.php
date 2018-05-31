<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 上午11:39
 */

//PHP中的聚合

interface Algorithm__ {
    public function algorithm($data) ;
}

class Sort implements Algorithm__ {

    public function algorithm($data) {
        echo var_dump($data);
        echo __CLASS__." ".__METHOD__."\n";
    }
}

class Split implements Algorithm__ {

    public function algorithm($data) {
        echo var_dump($data);
        echo __CLASS__." ".__METHOD__."\n";
    }
}

class Context {

    private $algorithm_ ;

    public function __construct(Algorithm__ $_alg) {
        $this->algorithm_ = $_alg;
    }

    public function algorithm($data) {
        $this->algorithm_->algorithm($data);
    }
}

//具体实现
$alg_sort = new Sort();
$alg_split = new Split();

$data = "1 2 3 4 5 6 7 8 9";

$controll_sort = new Context($alg_sort);
$controll_sqlit = new Context($alg_split);

$controll_sort->algorithm($data);
$controll_sqlit->algorithm($data);
