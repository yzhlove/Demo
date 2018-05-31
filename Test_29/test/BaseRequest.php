<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/13
 * Time: 下午5:09
 */


class BaseRequest {

    public $server;
    public $fd;
    public $data;
    public $action;

    public function __construct($server,$fd,$data)
    {
        $this->server = $server;
        $this->fd = $fd;
        $this->data = $data;
        $this->action = trim($this->data);
        echo "this->action = " . $this->action . "\n";

    }

}