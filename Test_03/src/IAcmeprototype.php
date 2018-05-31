<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午11:16
 */

//原型模式
abstract class IAcmeprototype__ {

    protected $name;
    protected $id;
    protected $employe_pic;
    protected $dept;

    abstract function setDepth($_index);
    abstract function getDepth();

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmployePic()
    {
        return $this->employe_pic;
    }

    /**
     * @param mixed $employe_pic
     */
    public function setEmployePic($employe_pic)
    {
        $this->employe_pic = $employe_pic;
    }

    /**
     * @return mixed
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     * @param mixed $dept
     */
    public function setDept($dept)
    {
        $this->dept = $dept;
    }



    abstract function __clone();

}

//测试
/*
class Npt extends IAcmeprototype__ {

    function setDepth($_index) {
        $this->dept = $_index;
    }

    function getDepth() {
        return $this->dept;
    }

    function __clone()
    {
        // TODO: Implement __clone() method.
    }
}

$npt = new Npt();
$npt->setDepth(123);
$npt->setName("yurisa");

echo $npt->getName()." ".$npt->getDepth();
*/



