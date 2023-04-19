<?php

namespace app\core;

use mysqli;

class Database
{


    public  mysqli $mysqli;




    public function __construct(array $config)
    {

        $hostName = $config['hostName'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $database = $config['database'] ?? '';
        $port = $config['port'] ?? '';
        $this->mysqli = new mysqli($hostName, $user, $password, $database, $port);
    }

    public function prepare($sql){
        return $this->mysqli->prepare($sql);
    }
}
