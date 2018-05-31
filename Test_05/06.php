<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/8
 * Time: 下午5:48
 */

class Test {
    public $mobile = "nokia";
    public function currentTest($type = true) {
        if ($type)
            return $this;
        return null;
    }
}

$ts = new Test();
if ( ($obj =  $ts->currentTest(false)) && $obj->mobile == 'nokia')
    echo "Hello World\n";
else
    echo "what are you doing.\n";

