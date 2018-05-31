<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/23
 * Time: 下午4:14
 */

//PHP中的抽象类
abstract class OneTrickAbstract__ {

    public $storehere_;

    abstract public function trick($whatever) ;

}

//抽象类的实现
class OneTrickConcreate extends OneTrickAbstract__ {

    public function trick($whatever) {
        $this->storehere_ = "This is abstract property!";
        return $whatever.$this->storehere_;
    }
}


$worker = new OneTrickConcreate();
echo $worker->trick(" From an abstract orign...");


?>