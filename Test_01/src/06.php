<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/23
 * Time: 下午5:50
 */

//PHP中的接口绑定
interface Product__ {
    public function apple();
    public function android();
}

class First implements Product__ {

    public function apple()
    {
        echo __CLASS__.__METHOD__.PHP_EOL;
    }

    public function android()
    {
        echo __CLASS__.__METHOD__.PHP_EOL;
    }
}

class Last implements Product__ {

    public function apple()
    {
        echo __CLASS__.__METHOD__.PHP_EOL;
    }

    public function android()
    {
        echo __CLASS__.__METHOD__.PHP_EOL;
    }
}

class Controol {

    public function doInterFace(Product__ $_p) {
        $_p->android();
        $_p->apple();
    }
}

$first = new First();
$last = new Last();

$con = new Controol();
$con->doInterFace($first);
$con->doInterFace($last);



