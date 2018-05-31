<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/26
 * Time: 下午5:28
 */

/* swoole文件传输技术 */

class server_socket {

    private $server;

    public function __construct() {

        $this->server = new swoole_server("127.0.0.1",9501);

        $this->server->set([
            "worker_num" => 2,
            "daemonize" => false,
            "max_request" => 100,
            "dispatch_mode" => 2,
            "debug_mode" => 1
        ]);

        $this->server->on("WorkerStart",[$this,"onWorkerStart"]);
        $this->server->on("Connect",[$this,"onConnect"]);
        $this->server->on("Receive",[$this,"onReceive"]);
        $this->server->on("Close",[$this,"onClose"]);

        $this->server->start();
    }

    public function stop() {
        $this->server->shutdown();
    }

    public function reload() {
        $this->server->reload();
    }

    public function onWorkerStart($server,$worker_id) {
        echo "__on_worker_start__ \n";
    }

    public function onConnect(swoole_server $server,$fd,$from_id) {
        echo "client [$fd] is connecting ... \n";
        $this->server->send($fd," server [connection successful!] \n");
    }

    public function onReceive(swoole_server $server,$fd,$from_id,$data) {
        $this->cmd($fd,$data);
    }

    public function onClose(swoole_server $server,$fd,$from_id) {
        echo "client [$fd] is close ... \n";
    }

    public function cmd($fd,$data) {

        $check_arr = [
            "--help" => false,
            "--get"  => false,
            "--show" => false,
            "--reload" => false,
            "--stop" => false,
            "--ip"   => false
        ];

        foreach ($check_arr as $key => $value) {
            if (($index = strpos($data,$key)) > -1) {
                switch($key) {
                    case "--help":
                        $str = "--help \n--get <filename>\n--show <filename>\n";
                        $this->server->send($fd,$str);
                        break;
                    case "--get" :
                        //发送文件技术
                        $filename = trim(substr($data,$index + strlen($key)));
                        if (!file_exists($filename))
                            return $this->server->send($fd,"$filename is not found!\n");

                        $this->server->send($fd,"file true");
                        $this->server->sendfile($fd,$filename);
                        $this->server->send($fd,"file false");
                        break;
                    case "--show":
                        $filename = trim(substr($data,$index + strlen($key)));
                        if (!file_exists($filename))
                            return $this->server->send($fd,"$filename is not found !\n");
                        $fsize = filesize($filename);
                        return $this->server->send($fd,$fsize . "B");
                        break;
                    case "--reload":
                        $this->reload();
                        break;
                    case "--stop":
                        $this->stop();
                        break;
                    case "--ip":
                        $arr = swoole_get_local_ip();
                        var_dump($arr);
                        break;
                }
                return;
            }
        }

        $this->server->send($fd,"cmd is failur !");
    }

}

new server_socket();