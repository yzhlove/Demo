<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/5
 * Time: 下午2:16
 */

/* 房间算法，测试 */

class TempRoom
{

    //房间（多维数组）
    /*
     * 表现形式
     * [
     *  1 => [              //房间ID
     *      '001' => 1,     //用户ID(001)以及对应的fd(1)
     *      '002' => 2
     *      ....
     *  ],
     *  2 => ...
     *
     * ]
     * */
    public static $ROOMS = [];

    //添加/更新用户
    public static function setUser($userId, $fd)
    {
        //判断房间是否为空
        if (empty(self::$ROOMS)) {
            array_push(self::$ROOMS, [$userId => $fd]);
            return self::$ROOMS[0][$userId];
        }
        $length = count(self::$ROOMS);
        //从每个房间开始找
        for ($i = 0; $i < $length; $i++) {
            $flag = false;
            $index = count(self::$ROOMS[$i]);
            //判断当前房间是否达到人数上限
            if ($index >= 4)
                $flag = true;
            //如果在当前房间找到用户，则更新信息
            foreach (self::$ROOMS[$i] as $user_id => $user_fd) {
                if ($user_id == $userId) {
                    self::$ROOMS[$i][$userId] = $fd;
                    return self::$ROOMS[$i][$userId];
                }
            }
            //没有找到用户且当前房间人数未满则直接添加用户
            if (!$flag) {
                self::$ROOMS[$i][$userId] = $fd;
                return self::$ROOMS[$i][$userId];
            }
        }
        //没有找到用户且所有的房间都满了则直接新增房间以及用户
        array_push(self::$ROOMS,[$userId => $fd]);
        return self::$ROOMS[$length][$userId];
    }

    //根据用户ID拿到所属房间以及所有用户
    public static function getRoom($userId) {
        foreach (self::$ROOMS as $index => $room) {
            foreach ($room as $user_id => $fd) {
                if ($userId == $user_id)
                    return [$index,$room];
            }
        }
    }

}


$user_arr = [1 => 1,2 => 2,3 => 3,4 => 12,5 => 5,6 => 16,7 => 17];
foreach ($user_arr as $key => $value)
    TempRoom::setUser($key,$value);

var_dump(TempRoom::$ROOMS);

for ($i = 1;$i <= 7;$i++)
     echo json_encode(TempRoom::getRoom($i)) . "\n";

////根据用户ID拿到房间
//$room = \TempRoom::getRoom("005");
//var_dump($room);
////推送消息到客户端
//$response = [
//    "msgId" => 120103,
//    "info" => [
//        "rid" => '002',
//        "roomId" => $room[0],
//        "room_user" => $room[1]
//    ]];

//var_dump($response);
//echo "\n--------------\n";
//var_dump($response['info']['room_user']);
//
//foreach ($response['info']['room_user'] as $fd) {
//    echo $fd . " - ";
//}
//
//echo "\n";
//
//$json = json_encode($response);
//echo $json;
//
//echo "\n--------------\n";
//
//var_dump(json_decode($json,true));
