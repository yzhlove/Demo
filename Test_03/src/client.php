<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午9:08
 */

//原型设计模式

include_once "MaleProto.php";
include_once "FemaleProto.php";

function __autoload($class_name) {
    include $class_name.'.php';
}

class Client {

    //用于直接实例话
    private $fly_1;
    private $fly_2;

    //用户克隆
    private $c_fly_1;
    private $c_fly_2;
    private $update_clone_fly;


    public function __construct() {

        $this->fly_1 = new MaleProto();
        $this->fly_2 = new FeMaleproto();

        //clone
        $this->c_fly_1 = clone $this->fly_1;
        $this->c_fly_2 = clone $this->fly_2;
        $this->update_clone_fly = clone $this->fly_2;

        //更新克隆
        $this->c_fly_1->mated = "true";
        $this->c_fly_2->fecundity = "186";

        $this->update_clone_fly->eye_color_ = "purple";
        $this->update_clone_fly->wing_beat_ = "220";
        $this->update_clone_fly->unit_eyes_ = "750";
        $this->update_clone_fly->fecundity = "92";

        //通过类型提示方法发送
        $this->showFly($this->c_fly_1);
        $this->showFly($this->c_fly_2);
        $this->showFly($this->update_clone_fly);

    }

    public function showFly(IPrototype__ $_fly) {

        echo "Eye Color: ".$_fly->eye_color_."\n";
        echo "WineBeats: ".$_fly->wing_beat_."\n";
        echo "Eye units: ".$_fly->unit_eyes_."\n";

        $genderNow = $_fly::GENDER;
        echo "GENDER: ".$genderNow."\n";

        if ($genderNow == "FEMALE")
            echo "Number of edds: ".$_fly->fecundity."\n";
        else
            echo "Mated: ".$_fly->mated."\n";

        echo "-------------------------------\n";

    }

}

$worker = new Client();

