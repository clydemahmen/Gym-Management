<?php

class User {
    private $conn;

    public function __construct($db){
        $this->conn = $db->getConnection();
    }

    public function findByUsername($username){
        $username = mysqli_real_escape_string($this->conn, $username);
        $result = mysqli_query($this->conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
        return mysqli_fetch_assoc($result);
    }

    public function getAll(){
        $result = mysqli_query($this->conn, "SELECT id, name, username, role, created_at FROM users ORDER BY created_at DESC");
        return $result;
    }

    public function create($name, $username, $password, $role){
        $name     = mysqli_real_escape_string($this->conn, $name);
        $username = mysqli_real_escape_string($this->conn, $username);
        $hashed   = password_hash($password, PASSWORD_DEFAULT);
        $role     = mysqli_real_escape_string($this->conn, $role);

        $query = "INSERT INTO users (name, username, password, role)
                  VALUES ('$name', '$username', '$hashed', '$role')";

        return mysqli_query($this->conn, $query);
    }
}

?>