<?php

class Database
{
    private $host = "localhost";
    private $db = "iot_project_db";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->username, $this->password);
        } catch (PDOException $exeption) {
            echo "Connection Error: " . $exeption->getMessage();
        }

        return $this->conn;
    }
}