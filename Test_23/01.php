<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/6
 * Time: 上午10:59
 */
/* PHP 设计模式之责任链模式 */

class Level {

    private $level = 0;

    public function __construct($level) {
        $this->level = $level;
    }

    public function above(Level $level) {
        if ($this->level > $level->level)
            return true;
        return false;
    }

}

class Request {

    public $level;

    public function __construct(Level $level) {
        $this->level = $level;
    }

    public function getLevel() {
        return $this->level;
    }

}

abstract class Handler {

    private $next_handler;

    public function handlerRequest(Request $request) {
        $response = null;

        if ($this->getHandlerLevel()->above($request->getLevel())) {
            $response = $this->response($request);
        } else {
            if ($this->next_handler)
                $this->next_handler->handlerRequest($request);
            else
                echo "request is not found !\n";
        }
        return $response;
    }

    public function setNextHandler(Handler $handler) {
        $this->next_handler = $handler;
    }

    /*
     * @return Level
     * */
    protected abstract function getHandlerLevel();
    /*
     * @return Request
     * */
    public abstract function response(Request $request);

}

class createHandler_1 extends Handler {

    protected function getHandlerLevel() {
        return new Level(1);
    }

    public function response(Request $request) {
        echo "------ level:1 ------";
    }
}

class createHandler_2 extends Handler {

    protected function getHandlerLevel() {
        return new Level(3);
    }

    public function response(Request $request) {
        echo "------ level:3 ------";
    }
}

class createHandler_3 extends Handler {

    protected function getHandlerLevel() {
        return new Level(5);
    }

    public function response(Request $request) {
        echo "------ level:5 ------";
    }
}

/* 客户端 */

$handler_1 = new createHandler_1();
$handler_2 = new createHandler_2();
$handler_3 = new createHandler_3();

$handler_1->setNextHandler($handler_2);
$handler_2->setNextHandler($handler_3);

$request = new Request(new Level(5));
$response = $handler_1->handlerRequest($request);