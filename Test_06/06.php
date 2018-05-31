<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/25
 * Time: 上午10:22
 */


/* PHP PDO 测试程序 */

$dbms = "pgsql";
$host = "localhost";
$dbname = "yzh";
$user = "postgres";
$pass = "";
$dsn = "$dbms:host=$host;dbname=$dbname";

try{

    $dbh = new PDO($dsn,$user,$pass);
    echo "$dbms connection successful! \n";

    foreach ($dbh->query('SELECT * FROM users') as $row)
        print_r($row);

    $dbh = null;

} catch (PDOException $exception) {
    die("Error!: " . $exception->getMessage() . "<br>");
}
