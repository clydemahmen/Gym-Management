<?php

class Database {
    private $connection;

    public function __construct(){
        $this->connection = mysqli_connect("sql100.infinityfree.com", "if0_41715287", "pSDF3Um3lTc", "if0_41715287_db_gymtrack");
        
        if(!$this->connection){
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getConnection(){
        return $this->connection;
    }

    public function escape($value){
        return mysqli_real_escape_string($this->connection, $value);
    }

    public function query($sql){
        return mysqli_query($this->connection, $sql);
    }

    public function close(){
        mysqli_close($this->connection);
    }
}

?>