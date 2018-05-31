<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/5
 * Time: 上午9:48
 */

/* interface测试 */

interface One {

    public function test_1();
    public function test_2();

}

interface Two {

    public function test_2();
    public function test_3();

}


class Test implements One , Two {


    public function test_1() {
        echo "Hello World";
    }

    public function test_2() {
        echo "what are you doing .";
    }

    public function test_3() {
        echo "yes i am going ";
    }

    public function show() {
        $this->test_1();
        $this->test_2();
        $this->test_3();
    }
}

$tts = new Test();
$tts->show();
