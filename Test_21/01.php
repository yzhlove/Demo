<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/4
 * Time: 下午3:45
 */

/* PHP call_user_func 测试 */

class TestClass {

    public function one() {
        echo "-- one --" . PHP_EOL;
    }

    public function two($a,$b) {
        echo "-- two -- $a - $b" . PHP_EOL;
    }

    public function three($a,$b,$c) {
        echo "-- three -- $a - $b - $c -" . PHP_EOL;


        $arguments = func_get_args();

        for ($i = 0;$i < func_num_args();$i++)
            echo "argument[$i] = " . func_get_arg($i) . PHP_EOL;

        echo "------------------" . PHP_EOL;

        var_dump($arguments);

    }

}

$test_class = new TestClass();


call_user_func_array([$test_class,"one"],[]);
call_user_func_array([$test_class,"two"],["yes","no"]);
call_user_func_array([$test_class,"three"],["one","two","three"]);


