<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/26
 * Time: 下午7:45
 */

/* PHP 文件随机写入技术 */

$filepath = "test.txt";

//打开文件
$fp = fopen($filepath,"w+");
if (!$fp) {
    echo "$filepath open error !\n";
    return ;
}

//判断文件是否可写
if (!is_writable($fp)) {
    echo "file is not file write ... \n";
}

fseek($fp,1024 * 1024 * 10 - 1,SEEK_SET);
echo "fp is " . ftell($fp) . "\n";

$status = fwrite($fp,'a',1);
echo "status = $status \n";
fclose($fp);


