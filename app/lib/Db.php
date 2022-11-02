<?php

namespace app\lib;

use PDO;

class Db
{
    protected $db;

    public function __construct()
    {
        $config = require 'app/config/db.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['name'] . ';charset=UTF8;', $config['user'], $config['password']);
    }

    public function query($sql, $params = array())
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = array())
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = array())
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}
