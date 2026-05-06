<?php

class Member {
    private $conn;

    public function __construct($db){
        $this->conn = $db->getConnection();
    }

    public function getAll($search = '', $status = ''){
        $where = "WHERE 1=1";

        if($search){
            $s = mysqli_real_escape_string($this->conn, $search);
            $where .= " AND (full_name LIKE '%$s%' OR email LIKE '%$s%' OR phone LIKE '%$s%')";
        }

        if($status){
            $st = mysqli_real_escape_string($this->conn, $status);
            $where .= " AND status='$st'";
        }

        $query = "SELECT * FROM members $where ORDER BY created_at DESC";
        return mysqli_query($this->conn, $query);
    }

    public function getById($id){
        $id = (int)$id;
        $result = mysqli_query($this->conn, "SELECT * FROM members WHERE id=$id");
        return mysqli_fetch_assoc($result);
    }

    public function create($data){
        $name    = mysqli_real_escape_string($this->conn, $data['full_name']);
        $email   = mysqli_real_escape_string($this->conn, $data['email']);
        $phone   = mysqli_real_escape_string($this->conn, $data['phone']);
        $address = mysqli_real_escape_string($this->conn, $data['address']);
        $type    = mysqli_real_escape_string($this->conn, $data['membership_type']);
        $status  = mysqli_real_escape_string($this->conn, $data['status']);

        $query = "INSERT INTO members (full_name, email, phone, address, membership_type, status)
                  VALUES ('$name', '$email', '$phone', '$address', '$type', '$status')";

        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data){
        $id      = (int)$id;
        $name    = mysqli_real_escape_string($this->conn, $data['full_name']);
        $email   = mysqli_real_escape_string($this->conn, $data['email']);
        $phone   = mysqli_real_escape_string($this->conn, $data['phone']);
        $address = mysqli_real_escape_string($this->conn, $data['address']);
        $type    = mysqli_real_escape_string($this->conn, $data['membership_type']);
        $status  = mysqli_real_escape_string($this->conn, $data['status']);

        $query = "UPDATE members SET full_name='$name', email='$email', phone='$phone',
                  address='$address', membership_type='$type', status='$status' WHERE id=$id";

        return mysqli_query($this->conn, $query);
    }

    public function delete($id){
        $id = (int)$id;
        return mysqli_query($this->conn, "DELETE FROM members WHERE id=$id");
    }

    public function countByStatus($status){
        $status = mysqli_real_escape_string($this->conn, $status);
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS c FROM members WHERE status='$status'");
        $row = mysqli_fetch_assoc($result);
        return $row['c'];
    }

    public function countAll(){
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS c FROM members");
        $row = mysqli_fetch_assoc($result);
        return $row['c'];
    }
}

?>