<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午3:10
 */

/*
 *  第一版:搭建工厂方法的模型
 *  第二版:修改GraphicsProduct产品
 *  第三版:修改TextProduct产品
 * */


include_once ("graphicsfactory.php");
include_once ("textfactory.php");

//第一版
/*
class Client {

    private $graphics_;
    private $text_;

    public function __construct() {

        $this->graphics_ = new GraphicsFactory();
        echo $this->graphics_->startFactory() . "\n";

        $this->text_ = new TextFactory();
        echo $this->text_->startFactory() . "\n";

    }

}

$worker = new Client();
*/

//第二版
class Client {

    private $graphics_;
    private $text_;

    public function __construct() {

        $this->graphics_ = new GraphicsFactory();
        echo $this->graphics_->startFactory();

        $this->text_ = new TextFactory();
        echo $this->text_->startFactory();

    }
}

$worker = new Client();
