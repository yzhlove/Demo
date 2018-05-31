<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午2:33
 */

include_once ("create.php");
include_once ("textproduct.php");

class TextFactory extends ICreate__  {

    protected function factoryMethod() {
        $product = new TextProduct();
        return $product->getProperties();
    }
}
