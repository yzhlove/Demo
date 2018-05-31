<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/28
 * Time: 下午7:52
 */

/* php 基础知识小demo */

class Table {

    private $user ;

    public function set($arr) {
        $this->user = new stdClass();
        $this->user->array_list = $arr;
    }

    public function print() {
        foreach ($this->user->array_list as $value)
            echo $value . ",";
    }

}

$arr = [1,2,3,4,5,6,7,8,9,0];

$table = new Table();
$table->set($arr);
$table->print();
