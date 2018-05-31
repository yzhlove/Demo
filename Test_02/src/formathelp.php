<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午8:36
 */



class FormatHelper {

    private $topper_;
    private $bottom_;

    public function addTop() {
        $this->topper_ = "<doctype html>";
        return $this->topper_;

    }

    public function closeUp() {
        $this->bottom_ = "</doctype html>";
        return $this->bottom_;
    }


}