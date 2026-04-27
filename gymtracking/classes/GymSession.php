<?php

class GymSession {
    private $conn;

    public function __construct($db){
        $this->conn = $db->getConnection();
    }

    public function getAll($search = '', $status = ''){
        $where = "WHERE 1=1";

        if($search){
            $s = mysqli_real_escape_string($this->conn, $search);
            $where .= " AND (m.full_name LIKE '%$s%' OR s.session_type LIKE '%$s%')";
        }

        if($status){
            $st = mysqli_real_escape_string($this->conn, $status);
            $where .= " AND s.status='$st'";
        }

        $query = "SELECT s.*, m.full_name AS member_name, m.membership_type, u.name AS staff_name
                  FROM sessions s
                  JOIN members m ON s.member_id = m.id
                  JOIN users u ON s.user_id = u.id
                  $where
                  ORDER BY s.session_date DESC";

        return mysqli_query($this->conn, $query);
    }

    public function getById($id){
        $id = (int)$id;
        $result = mysqli_query($this->conn, "SELECT * FROM sessions WHERE id=$id");
        return mysqli_fetch_assoc($result);
    }

    public function create($data, $user_id){
        $member_id = (int)$data['member_id'];
        $user_id   = (int)$user_id;
        $type      = mysqli_real_escape_string($this->conn, $data['session_type']);
        $date      = mysqli_real_escape_string($this->conn, $data['session_date']);
        $start     = mysqli_real_escape_string($this->conn, $data['start_time']);
        $end       = mysqli_real_escape_string($this->conn, $data['end_time']);
        $amount    = (float)$data['amount'];
        $status    = mysqli_real_escape_string($this->conn, $data['status']);
        $notes     = mysqli_real_escape_string($this->conn, $data['notes']);

        $query = "INSERT INTO sessions (member_id, user_id, session_type, session_date, start_time, end_time, amount, status, notes)
                  VALUES ($member_id, $user_id, '$type', '$date', '$start', '$end', $amount, '$status', '$notes')";

        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data){
        $id     = (int)$id;
        $type   = mysqli_real_escape_string($this->conn, $data['session_type']);
        $date   = mysqli_real_escape_string($this->conn, $data['session_date']);
        $start  = mysqli_real_escape_string($this->conn, $data['start_time']);
        $end    = mysqli_real_escape_string($this->conn, $data['end_time']);
        $amount = (float)$data['amount'];
        $status = mysqli_real_escape_string($this->conn, $data['status']);
        $notes  = mysqli_real_escape_string($this->conn, $data['notes']);

        $query = "UPDATE sessions SET session_type='$type', session_date='$date',
                  start_time='$start', end_time='$end', amount=$amount,
                  status='$status', notes='$notes' WHERE id=$id";

        return mysqli_query($this->conn, $query);
    }

    public function delete($id){
        $id = (int)$id;
        return mysqli_query($this->conn, "DELETE FROM sessions WHERE id=$id");
    }

    public function countByStatus($status){
        $status = mysqli_real_escape_string($this->conn, $status);
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS c FROM sessions WHERE status='$status'");
        $row = mysqli_fetch_assoc($result);
        return $row['c'];
    }

    public function totalRevenue(){
        $result = mysqli_query($this->conn, "SELECT SUM(amount) AS total FROM sessions WHERE status='Completed'");
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0;
    }
}

?>