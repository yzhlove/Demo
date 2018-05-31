<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午8:41
 */

include_once "countryfactory.php";
include_once "NTextProduct.php";
include_once "MoldovProduct.php";

//文件组织形式
/*
 * client.php
 *
 *
 * */


class Client {

    private $countFactory_;

    public function __construct() {
//        $this->countFactory_ = new CountryFactory();
//        echo $this->countFactory_->doFactory(new KProduct());

        $this->countFactory_ = new MoldovaProduct();
        echo $this->countFactory_->getProperties();
    }

}

$worker = new Client();