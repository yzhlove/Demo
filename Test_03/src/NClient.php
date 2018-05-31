<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午11:56
 */

include_once "Marketing.php";
include_once "ManageMent.php";
include_once "Engineering.php";

class Client {

    private $market;
    private $manage;
    private $enginner;

    public function __construct()
    {

        $this->init();
        $picture = "https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/ShanghaiMinxang11.jpg/220px-ShanghaiMinxang11.jpg";
        $ts = clone $this->market;
        $this->setEmployee($ts, "Tess Smith", 101, "ts101-1234", $picture);
        $this->showEmployee($ts);

        $jb = clone $this->market;
        $this->setEmployee($jb, "Jacob Jones", 102, "jb102-1234", $picture);
        $this->showEmployee($ts);

        $rk = clone $this->manage;
        $this->setEmployee($rk, "Ricky Rodriguze", 203, "rr203-5634", $picture);
        $this->showEmployee($rk);

        $oa = clone $this->enginner;
        $this->setEmployee($oa, "oasss oeass", 302, "oa302-1234", $picture);
        $this->showEmployee($oa);

        $jh = clone $this->enginner;
        $this->setEmployee($jh, "Jaback Josh", 301, "jh302-1234", $picture);
        $this->showEmployee($jh);

    }
    private function init() {
        $this->market = new Marking();
        $this->manage = new ManageMent();
        $this->enginner = new Engineering();
    }

    private function showEmployee(IAcmeprototype__ $_ai) {
        $px=  $_ai->getEmployePic();
        echo "<img src='$px' width='150px' height='150px'><br>";
        echo $_ai->getName()."<br>";
        echo $_ai->getDepth()." : ".$_ai::UNIT."<br>";
        echo $_ai->getId()."<br>";
        echo "\n";

    }

    private function setEmployee(IAcmeprototype__ $_ai,$nm,$dp,$id,$px) {
        $_ai->setName($nm);
        $_ai->setDepth($dp);
        $_ai->setId($id);
        $_ai->setEmployePic($px);
    }

}

$work = new Client();
