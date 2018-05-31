<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/8
 * Time: 下午8:53
 */

class Testpara {

    public $one = "one_1";
    public $two = "two_2";
    public $three = "three_3";

    public function getParaments($arg = "") {
       if ($arg != ""){
           return $this->$arg;
       }
    }

}

$tp = new Testpara();

echo $tp->getParaments("one");
echo "\n";

$arr = ["one"=>"","two"=>"","three"=>""];
foreach ($arr as $key => $value) {
    echo $key." => ";
    $arr[$key] = $tp->getParaments($key);
    echo $value."\n";
}

var_dump($arr);
