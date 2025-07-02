<?php

class UserLogin
{
    private $conn;
    private $table_name = "admindpi";
    public $username;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setusername($username)
    {
        $this->username = $username;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function usernameNotExits()
    {
        $query = "SELECT id FROM {$this->table_name} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function verifyPassword()
    {
        $query = "SELECT id, password FROM {$this->table_name} WHERE username = :username AND password = :password LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return true;
        }
        return false;
    }
}
