<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 29.04.18
 * Time: 14:58
 */

namespace Angle\Utility;


class MySQLHandler {

    private $host;
    private $user;
    private $password;
    private $db;

    private $mysql;

    public function __construct($host, $user, $password, $db) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;

        $this->mysql = new \MySQLi($host, $user, $password, $db);
    }
    public function query($sql) {
        return $this->mysql->query($sql);
    }
    /*
     *
     * { "s" => "asd", "i" => 10 }
     *
     */
    public function prepare($sql, $params = array()) {
        if ($stmt = $this->mysql->prepare($sql)) {
            foreach ($params as $type => $value) {
                $stmt->bind_param($type, $value);
            }
            $stmt->execute();
            $stmt->bind_result($returner);
            $stmt->fetch();
            $stmt->close();
            return $returner;
        }
    }
    public function escape($p) {
        return $this->mysql->real_escape_string($p);
    }
    public function get() {
        return $this->mysql;
    }
}