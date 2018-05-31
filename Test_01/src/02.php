<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/23
 * Time: 下午3:38
 */

//打开错误处理
ini_set("display_errors",true);
error_reporting(E_ALL | E_STRICT);

class MobileSniffer {

    private $userAgent;
    private $device;
    private $browser;
    private $deviceLength;
    private $browserLength;

    public function __construct() {

        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->userAgent = strtolower($this->userAgent);

        $this->device = ['iphone','ipad','android','msie','silk','blackberry','touch'];
        $this->browser = ['firefox','chrome','opera','msie','safari','blackberry','trident'];

        $this->deviceLength = count($this->device);
        $this->browserLength = count($this->browser);
    }

    public function findDevice() {
        for ($index = 0; $index < $this->deviceLength; $index++) {
            if (strstr($this->userAgent,$this->device[$index]))
                return $this->device[$index];
        }
    }

    public function findBrower() {
        for ($index = 0;$index < $this->browserLength;$index++) {
            if (strstr($this->userAgent,$this->browser[$index]))
                return $this->browser[$index];
        }
    }

}


//使用Client实例话MobileSniffer类
class Client {

    private $mobile;
    public function __construct() {
        $this->mobile = new MobileSniffer();
        echo "Device = ".$this->mobile->findDevice()."<br>";
        echo "Brower = ".$this->mobile->findBrower()."<br>";
    }

}

//测试
$client = new Client();



?>