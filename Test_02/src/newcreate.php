<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午8:18
 */

//PHP新工厂
abstract class NICreate_ {

    protected abstract function factorymethod(NIProduct__ $_product) ;

    public function doFactory($_productNow) {
        $countryProduct = $_productNow;
        $msg = $this->factorymethod($countryProduct);
        return $msg;
    }

}

