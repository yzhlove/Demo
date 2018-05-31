<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/11
 * Time: 下午4:17
 */


//php 设计模式之观察者模式

abstract class Observer {
    protected $subject;
    public abstract function update();
}


class Subject {

    private $list = [];
    public $stat;

    public function getState() {
        return $this->stat;
    }

    public function setState($stat) {
        $this->stat = $stat;
    }

    public function add(Observer $observer) {
        $this->list[] = $observer;
    }

    public function remove(Observer $observer) {
        unset($this->list,$observer);
    }

    public function notify() {
        foreach ($this->list as $obs) {
            $obs->update();
        }
    }

}

class BinaryObserver extends Observer {

    public function __construct(Subject $subject) {
        $this->subject = $subject;
        $this->subject->add($this);
    }

    public function update() {
        echo "Bianry String: " . $this->subject->getState() . "\n";
    }
}

class HexObserver extends Observer {

    public function __construct(Subject $subject) {
        $this->subject = $subject;
        $this->subject->add($this);
    }

    public function update() {
        echo "Hex String: " . $this->subject->getState() . "\n";
    }
}

//client

$subject = new Subject();
new BinaryObserver($subject);
new HexObserver($subject);

$subject->setState(100);
$subject->notify();