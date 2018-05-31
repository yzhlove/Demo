<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/13
 * Time: 下午5:11
 */


abstract class BaseHandler {

    public $nexHandler;

    public function setNextHandler(BaseHandler $bsn) {
        $this->nexHandler = $bsn;
    }

    public abstract function HandlerRequest(BaseRequest $request);

}