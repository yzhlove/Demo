<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午8:56
 */

include_once "formathelp.php";
include_once "newproduct.php";

class MoldovaProduct implements NIProduct__ {

    private $mfgproduct_;
    private $formatHelper_;
    private $countryNow_;

    public function getProperties() {

        $this->countryNow_ = file_get_contents("yzh.txt");
        $this->formatHelper_ = new FormatHelper();
        $this->mfgproduct_ = $this->countryNow_;
        $this->mfgproduct_ .= $this->formatHelper_->addTop();

        $this->mfgproduct_ .= "<a href='www.baidu.com'>baidu</a>";

        $this->mfgproduct_ .= $this->formatHelper_->closeUp();
        return $this->mfgproduct_;
    }
}
