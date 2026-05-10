<?php

class Order {
    private $conn;

    public function __construct($db){
        $this->conn = $db->getConnection();
    }

    public function getAll($search = '', $status = ''){
        $where = "WHERE 1=1";

        if($search){
            $s = mysqli_real_escape_string($this->conn, $search);
            $where .= " AND (o.equipment_name LIKE '%$s%' OR m.full_name LIKE '%$s%')";
        }

        if($status){
            $st = mysqli_real_escape_string($this->conn, $status);
            $where .= " AND o.status='$st'";
        }

        $query = "SELECT o.*, m.full_name AS member_name, u.name AS staff_name
                  FROM orders o
                  JOIN members m ON o.member_id = m.id
                  JOIN users u ON o.user_id = u.id
                  $where
                  ORDER BY o.created_at DESC";
        return mysqli_query($this->conn, $query);
    }

    public function getById($id){
        $id = (int)$id;
        $result = mysqli_query($this->conn,
            "SELECT o.*, m.full_name AS member_name, u.name AS staff_name
             FROM orders o
             JOIN members m ON o.member_id = m.id
             JOIN users u ON o.user_id = u.id
             WHERE o.id=$id"
        );
        return mysqli_fetch_assoc($result);
    }

    public function create($data){
        $member_id = (int)$data['member_id'];
        $user_id   = (int)$data['user_id'];
        $equipment = mysqli_real_escape_string($this->conn, $data['equipment_name']);
        $quantity  = (int)$data['quantity'];
        $price     = (float)$data['price'];
        $status    = mysqli_real_escape_string($this->conn, $data['status']);

        $query = "INSERT INTO orders (member_id, user_id, equipment_name, quantity, price, status)
                  VALUES ($member_id, $user_id, '$equipment', $quantity, $price, '$status')";

        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data){
        $id        = (int)$id;
        $member_id = (int)$data['member_id'];
        $equipment = mysqli_real_escape_string($this->conn, $data['equipment_name']);
        $quantity  = (int)$data['quantity'];
        $price     = (float)$data['price'];
        $status    = mysqli_real_escape_string($this->conn, $data['status']);

        $query = "UPDATE orders SET member_id=$member_id, equipment_name='$equipment',
                  quantity=$quantity, price=$price, status='$status' WHERE id=$id";

        return mysqli_query($this->conn, $query);
    }

    public function delete($id){
        $id = (int)$id;
        return mysqli_query($this->conn, "DELETE FROM orders WHERE id=$id");
    }

    public function countByStatus($status){
        $status = mysqli_real_escape_string($this->conn, $status);
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS c FROM orders WHERE status='$status'");
        $row = mysqli_fetch_assoc($result);
        return $row['c'];
    }

    public function countAll(){
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS c FROM orders");
        $row = mysqli_fetch_assoc($result);
        return $row['c'];
    }

    public function totalRevenue(){
        $result = mysqli_query($this->conn,
            "SELECT SUM(price * quantity) AS total FROM orders WHERE status='Delivered'"
        );
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function getRecentOrders($limit = 5){
        $limit = (int)$limit;
        $query = "SELECT o.*, m.full_name AS member_name, u.name AS staff_name
                  FROM orders o
                  JOIN members m ON o.member_id = m.id
                  JOIN users u ON o.user_id = u.id
                  ORDER BY o.created_at DESC
                  LIMIT $limit";
        return mysqli_query($this->conn, $query);
    }
}

?>
