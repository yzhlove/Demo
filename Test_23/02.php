<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/6
 * Time: 下午1:50
 */

/* 职责链模式，变种 */

class client {

    public $string_level_name;
    public $int_level_days;

    public function __construct($string_level_name,$int_level_days) {
        $this->string_level_name = $string_level_name;
        $this->int_level_days = $int_level_days;
    }

}

abstract class Handler {

    protected $string_name;
    protected $next_handler;

    public function __construct($string_name) {
        $this->string_name = $string_name;
    }

    public function setNextHandler(Handler $next_handler) {
        $this->next_handler = $next_handler;
    }

    public abstract function HandlerRequest(client $request) ;

}

class GroupLeader extends Handler {

    public function __construct($string_name) {
        parent::__construct($string_name);
    }


    public function HandlerRequest(client $request) {

        //传递一级任务
//        if ($request->int_level_days <= 1) {
//            echo "i love " . $request->string_level_name . "\n";
//        } elseif ($this->next_handler) {
//            $this->next_handler->HandlerRequest($request);
//        } else {
//            echo "this is shit ... \n";
//        }

        //传递多级任务
        echo $this->string_name . " i love " . $request->string_level_name . "\n";

        if ($this->next_handler)
            $this->next_handler->HandlerRequest($request);
        else
            echo " ... .... \n";

    }
}

$group = new GroupLeader('one');
$manage = new GroupLeader('two');
$hr = new GroupLeader('three');

$group->setNextHandler($manage);
$manage->setNextHandler($hr);

$cli = new client('yurisa',1);
$group->HandlerRequest($cli);
