<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/23
 * Time: 下午4:22
 */

//PHP中的接口
interface MethodHolder__ {

    public function getInfo($info);
    public function sendInfo($info);
    public function calculate($first,$second);

}

class Alpha implements MethodHolder__ {

    public function getInfo($info) {
        echo "This is News!".$info."<br>";
    }

    public function sendInfo($info) {
        return $info;
    }

    public function calculate($first, $second) {
        $result = $first * $second;
        return $result;
    }

    public function useMethods() {

        $this->getInfo("This sky is falling...");
        echo $this->sendInfo("Hello World ... ");
        echo $this->calculate(20,40);
    }

}


$worker = new Alpha();
$worker->useMethods();

?>