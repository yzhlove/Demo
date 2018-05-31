<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 上午9:36
 */


//PHP中的继承与组合
class DoMath {

    private $sum;
    private $quotient;

    public function simple_add($first,$second) {
        $this->sum = $first + $second;
        return $this->sum;
    }

    public function simple_mutlit($first,$second) {
        $this->quotient = $first * $second;
        return $this->quotient;
    }

}


//使用继承
class ExtendsMath extends DoMath {
    private $text_out;
    private $full_face;

    public function numToText($num) {
        $this->text_out = (string)$num;
        return $this->text_out;
    }

    public function addFace($face,$msg) {
        $this->full_face = "<strong>".$face."</strong> :".$msg;
        return $this->full_face;
    }

}

//控制器
class ClientExtends {

    private $added;
    private $divided;
    private $textnum;
    private $output;

    public function __construct() {
        $family = new ExtendsMath();
        $this->added = $family->simple_add(40,60);
        $this->divided = $family->simple_mutlit($this->added,25);
        $this->textnum = $family->numToText($this->divided);
        $this->output = $family->addFace("[ result ]",$this->textnum);
        echo $this->output;
    }

}

class DoText {
    private $text_out;
    private $full_face;

    public function numToText($num) {
        $this->text_out = (string)$num;
        return $this->text_out;
    }

    public function addFace($face,$msg) {
        $this->full_face = "<strong>".$face."</strong>".$msg;
        return $this->full_face;
    }
}

class CilentCompse {

    private $added;
    private $divided;
    private $textnum;
    private $output;

    public function __construct() {

        $math = new DoMath();
        $text = new DoText();

        $this->added = $math->simple_add(40,60);
        $this->divided = $math->simple_mutlit($this->added,25);
        $this->textnum = $text->numToText($this->divided);
        $this->output = $text->addFace("( result )",$this->textnum);
        echo $this->output;

    }

}

//使用继承
$work = new ClientExtends();
echo "\n";
$client = new CilentCompse();
