<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/23
 * Time: 下午5:04
 */

//PHP接口中的常量的使用
interface Connection__ {
    const HOST = "localhost";
    const NAME = "postgres";
    const DB_ANME = "yzh";
    const PORT = "5432";
}

class ConSQL implements Connection__ {

    public $host = "host=".Connection__::HOST." ";
    public $port = "port=".Connection__::PORT." ";
    public $name = "dbname=".Connection__::DB_ANME." ";
    public $user = "user=".Connection__::NAME." ";

    public function testConnect() {
        $conn = $this->host.$this->port.$this->name.$this->user;
        $db = pg_connect($conn);

        if (!$db)
            die("CONN:postgres connection error!");
        echo "connection suuess!";
        pg_close($db);
    }

}

$con = new ConSQL();
$con->testConnect();



