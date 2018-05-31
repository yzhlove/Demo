<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午8:22
 */

include_once ("newcreate.php");
include_once ("product.php");

class CountryFactory extends NICreate_ {

    private $country;

    protected function factorymethod(NIProduct__ $_product) {
        $this->country = $_product;
        return $this->country->getProperties();
    }
}
