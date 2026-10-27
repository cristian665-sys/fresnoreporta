<?php
// app/config/database.php

class Database {
    private $host = "127.0.0.1";
    private $db_name = "fresno_reporta";
    private $username = "root";
    private $password = "";
    public $conn;

    public function conectar() {
        $this->conn = null;
        try {
            // Forzamos un tiempo de espera corto (3 segundos) para que si falla, bote el error de inmediato en lugar de congelarse
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 3
            ];
            ini_set('mysqlnd.net_read_timeout', '3');
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8;connect_timeout=3";
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $exception) {
            error_log('[Fresno Reporta][Database] ' . $exception->getMessage());
            throw $exception;
        }
        return $this->conn;
    }
}
?>