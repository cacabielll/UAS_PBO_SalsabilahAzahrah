<?php

class Database {
    public $conn;

    public function __construct() {
        $host     = 'localhost';
        $user     = 'root';
        $password = '';
        $dbname   = 'db_uas_pbo_SalsabilahAzahrah';

        $this->conn = new mysqli($host, $user, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }

        $this->conn->set_charset('utf8mb4');
    }
}