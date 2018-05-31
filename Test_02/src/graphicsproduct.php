<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午3:00
 */

include_once ("./product.php");

//第一版
/*
class GraphicsProduct implements IProduct__  {

    private $mfgProduct;

    public function getProperties() {
        $this->mfgProduct = "This is graphics";
        return $this->mfgProduct;
    }
}
*/


//第二版
class GraphicsProduct implements IProduct__ {

    private $msgProduct;

    public function getProperties() {

        $this->mfgProduct = <<<EOF
        <html>
            <head>
                <title>*</title>
            </head>
            <body>
                <a href="www.baidu.com" target = "_blank">众里寻她千百度</a> 
            <body>
        </html>
EOF;
        return $this->mfgProduct;
    }

}


