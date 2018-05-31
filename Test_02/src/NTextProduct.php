<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午8:30
 */

//工厂方法设计模式

include_once ("newproduct.php");
include_once ("formathelp.php");

class KProduct implements NIProduct__ {

    private $mfgproduct_;
    private $formatHelp_;

    public function getProperties() {

        $this->formatHelp_ = new FormatHelper();
        $this->mfgproduct_ = $this->formatHelp_->addTop();
        $this->mfgproduct_ .= "<html>This is centen code</html>";
        $this->mfgproduct_ .= $this->formatHelp_->closeUp();

        return $this->mfgproduct_;
    }
}