<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/26
 * Time: 下午4:46
 */

/* PDO测试 */

$dbms = "pgsql";
$host = "localhost";
$dbname = "yzh";
$user = "postgres";
$pass = "";
$dsn = "$dbms:host=$host;dbname=$dbname";

try{

    $pdo = new PDO($dsn,$user,$pass);
    echo "$dbms connectionful ! \n";

    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $email);

    $name = "live";
    $email = "live.cn@email.com";
    $stmt->execute();
    echo "Sql 执行成功!\n";
} catch (PDOException $exception) {
    die("Error!" . $exception->getMessage() . "\n");
}
