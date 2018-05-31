<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午2:57
 */

include_once ("product.php");

//第一版
/*
class TextProduct implements IProduct__  {

    private $mfgProduct;

    public function getProperties() {
        $this->mfgProduct = "This is text";
        return $this->mfgProduct;
    }

}
*/

//第三版
class TextProduct implements IProduct__ {

    private $mfgProduct;
    public function getProperties() {
        $this->mfgProduct = <<<EOF
        <style>
            header {
                color:#9000;
                font-weight:bold;
                font-size:24px;
            }
        </style>
EOF;
    return $this->mfgProduct;
    }
}
