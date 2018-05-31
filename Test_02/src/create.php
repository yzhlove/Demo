<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 下午2:32
 */

//工厂方法模式
abstract class ICreate__ {

    protected abstract function factoryMethod() ;

    public function startFactory() {
        $mfg = $this->factoryMethod();
        return $mfg;
    }

}