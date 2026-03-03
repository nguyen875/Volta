<?php
require_once __DIR__ . '/../../config/database.php';

class CustomerDAO {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    public function getByUserId($uid) {
        try {
            $sql = "SELECT c.*, l.Name, l.Email 
                    FROM CUSTOMER c
                    JOIN LOGIN l ON c.UID = l.UID
                    WHERE c.UID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$uid]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("CustomerDAO getByUserId error: " . $e->getMessage());
            return null;
        }
    }
    
    public function updateInfo($uid, $phoneNum, $address) {
        try {
            $sql = "UPDATE CUSTOMER SET PhoneNum = ?, Address = ? WHERE UID = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$phoneNum, $address, $uid]);
        } catch (Exception $e) {
            error_log("CustomerDAO updateInfo error: " . $e->getMessage());
            return false;
        }
    }
}
