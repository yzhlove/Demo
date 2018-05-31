<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 上午9:01
 */

//PHP抽象接口编程

abstract class Abstract__ {

    protected $value_now_;

    abstract protected function getCost();
    abstract protected function getCity();

    public function display_show() {
        $string_cost = $this->getCost();
        $string_cost = (string)$string_cost;
        $to_interage = "(cost :".$string_cost." for ".$this->getCity().")";
        return $to_interage;
    }
}

//抽象类扩展
class NotrhRegion extends Abstract__ {
    protected function getCost() {
        return 251.4;
    }

    protected function getCity() {
        return "<".__CLASS__." ".__METHOD__.">";
    }
}


class WestRegion extends Abstract__ {
    protected function getCost() {
        $value = 2;
        $this->value_now_ = 100 >> $value;
        return $this->value_now_;
    }

    protected function getCity() {
        return "<".__CLASS__." ".__METHOD__.">";
    }
}

class Controller {

    public function __construct() {
        $north = new NotrhRegion();
        $west = new WestRegion();
        $this->show_interface($north);
        $this->show_interface($west);
    }

    private function show_interface(Abstract__ $_ite) {
        echo $_ite->display_show();
    }

}


$work = new Controller();