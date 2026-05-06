<?php

/**
 * MLModel.php
 * Feature: Customer Classification
 * Classifies customers as:
 *   - Frequent Buyer   (3+ orders)
 *   - Occasional Buyer (1-2 orders)
 *   - New Customer     (0 orders)
 */

class MLModel {

    private $conn;

    public function __construct($db){
        $this->conn = $db->getConnection();
    }

    /**
     * preprocessData()
     * Extract data from MySQL and convert into arrays/datasets usable by the ML classification model
     */
    public function preprocessData(): array {
        $query = "
            SELECT 
                m.id,
                m.full_name,
                m.membership_type,
                m.status,
                COUNT(o.id) AS total_orders,
                COALESCE(SUM(o.quantity), 0) AS total_items,
                COALESCE(SUM(o.price * o.quantity), 0) AS total_spent,
                MAX(o.created_at) AS last_order_date
            FROM members m
            LEFT JOIN orders o ON m.id = o.member_id
            GROUP BY m.id
            ORDER BY total_orders DESC
        ";

        $result = mysqli_query($this->conn, $query);
        $data   = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    /**
     * classify()
     * Model processing — applies classification rules to determine customer type based on order count
     */
    public function classify(int $totalOrders): string {
        if($totalOrders >= 3){
            return 'Frequent Buyer';
        } elseif($totalOrders >= 1){
            return 'Occasional Buyer';
        } else {
            return 'New Customer';
        }
    }

    /**
     * trainModel()
      * Runs classification on the full dataset
     * Returns all customers with their ML classification label
     */
    public function trainModel(): array {
        $dataset = $this->preprocessData();
        $results = [];

        foreach($dataset as $customer){
            $label     = $this->classify((int)$customer['total_orders']);
            $results[] = array_merge($customer, ['classification' => $label]);
        }

        return $results;
    }

    /**
     * predict()
     * Output: Predicts the classification of a single customer by ID
     */
    public function predict(int $memberId): string {
        $id     = (int)$memberId;
        $result = mysqli_query($this->conn,
            "SELECT COUNT(*) AS total FROM orders WHERE member_id=$id"
        );
        $row = mysqli_fetch_assoc($result);
        return $this->classify((int)$row['total']);
    }

    /**
     * getFrequentBuyers()
     * Returns only customers classified as Frequent Buyers
     * — the main ML output shown on the dashboard
     */
    public function getFrequentBuyers(): array {
        $all = $this->trainModel();
        return array_values(array_filter($all, function($c){
            return $c['classification'] === 'Frequent Buyer';
        }));
    }

    /**
     * getSummary()
     * Returns count of each classification group
     */
    public function getSummary(): array {
        $classified = $this->trainModel();
        $summary    = [
            'Frequent Buyer'   => 0,
            'Occasional Buyer' => 0,
            'New Customer'     => 0,
        ];
        foreach($classified as $c){
            $summary[$c['classification']]++;
        }
        return $summary;
    }
}

?>
