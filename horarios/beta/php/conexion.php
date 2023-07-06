<?php
class Conexion {
    private $host = 'localhost';
    private $dbname = 'sarec';
    private $user = 'postgres';
    private $password = '123';
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("pgsql:host={$this->host};dbname={$this->dbname}", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
