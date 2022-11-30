<?php
namespace application\lib;

use PDO;

class Db {
    protected $db;

    public function __construct(){
        $config = require 'application/config/db.php';
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['dbname'];
        $user = $config['username'];
        $password = $config['password'];
        $this->db = new PDO($dsn,$user,$password);
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}