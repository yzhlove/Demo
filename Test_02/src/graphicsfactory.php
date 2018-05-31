<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午2:59
 */

include_once ("create.php");
include_once ("graphicsproduct.php");

class GraphicsFactory extends ICreate__  {

    protected function factoryMethod() {
        $product = new GraphicsProduct();
        return $product->getProperties();
    }
}