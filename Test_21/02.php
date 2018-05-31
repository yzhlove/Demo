<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/4
 * Time: 下午4:46
 */

namespace Test_21;

class TestGame {

    public function __construct() {

        echo "在离这很远的地方，有一片海滩" . PHP_EOL;

    }

    public function gameStart($game_id) {
        echo "id = $game_id" . PHP_EOL;
        echo "孤独的人她就在海上，撑着船帆" . PHP_EOL;
        return "如果你看到她，回到海岸，就请你高诉她你的名字，我的名字" . PHP_EOL;
    }

}

echo "namespace :" . __NAMESPACE__ . PHP_EOL;

$ts = new \Test_21\TestGame();
$result = call_user_func_array([$ts,'gameStart'],[101]);
echo $result;
