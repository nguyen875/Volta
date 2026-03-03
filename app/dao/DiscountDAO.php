<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Discount.php';

class DiscountDAO {
    private $db;
    
    public function __construct() {
        $this->db = getDB(); // PDO instance
    }
    
    /**
     * Create a new discount
     */
    public function create($discount) {
        try {
            $sql = "INSERT INTO DISCOUNT_COUPON (Code, MoneyDeduct, Condition, Quantity, Status) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                $discount->getCode(),
                $discount->getMoneyDeduct(),
                $discount->getCondition(),
                $discount->getQuantity(),
                $discount->getStatus()
            ]);
        } catch (Exception $e) {
            error_log("DiscountDAO create error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get all discounts
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM DISCOUNT_COUPON ORDER BY Discount_ID DESC";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $discounts = [];
            foreach ($result as $row) {
                $discounts[] = new Discount(
                    $row['Discount_ID'],
                    $row['Code'],
                    floatval($row['MoneyDeduct']),
                    $row['Condition'],
                    intval($row['Quantity']),
                    $row['Status']
                );
            }
            
            return $discounts;
        } catch (Exception $e) {
            error_log("DiscountDAO getAll error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get discount by ID
     */
    public function getById($id) {
        try {
            $sql = "SELECT * FROM DISCOUNT_COUPON WHERE Discount_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                return new Discount(
                    $row['Discount_ID'],
                    $row['Code'],
                    floatval($row['MoneyDeduct']),
                    $row['Condition'],
                    intval($row['Quantity']),
                    $row['Status']
                );
            }
            
            return null;
        } catch (Exception $e) {
            error_log("DiscountDAO getById error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Update a discount
     */
    public function update($discount) {
        try {
            $sql = "UPDATE DISCOUNT_COUPON 
                    SET Code = ?, MoneyDeduct = ?, Condition = ?, Quantity = ?, Status = ?
                    WHERE Discount_ID = ?";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                $discount->getCode(),
                $discount->getMoneyDeduct(),
                $discount->getCondition(),
                $discount->getQuantity(),
                $discount->getStatus(),
                $discount->getId()
            ]);
        } catch (Exception $e) {
            error_log("DiscountDAO update error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get discount by code
     */
    public function getByCode($code) {
        try {
            $sql = "SELECT * FROM DISCOUNT_COUPON WHERE Code = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$code]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                return new Discount(
                    $row['Discount_ID'],
                    $row['Code'],
                    floatval($row['MoneyDeduct']),
                    $row['Condition'],
                    intval($row['Quantity']),
                    $row['Status']
                );
            }
            
            return null;
        } catch (Exception $e) {
            error_log("DiscountDAO getByCode error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Delete a discount
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM DISCOUNT_COUPON WHERE Discount_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
        } catch (Exception $e) {
            error_log("DiscountDAO delete error: " . $e->getMessage());
        }
    }
    
    /**
     * Get only active discounts
     */
    public function getActiveDiscounts() {
        try {
            $sql = "SELECT * FROM DISCOUNT_COUPON WHERE Status = 'Activate' AND Quantity > 0 ORDER BY MoneyDeduct DESC";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $discounts = [];
            foreach ($result as $row) {
                $discounts[] = new Discount(
                    $row['Discount_ID'],
                    $row['Code'],
                    floatval($row['MoneyDeduct']),
                    $row['Condition'],
                    intval($row['Quantity']),
                    $row['Status']
                );
            }
            
            return $discounts;
        } catch (Exception $e) {
            error_log("DiscountDAO getActiveDiscounts error: " . $e->getMessage());
            return [];
        }
    }
}
?>
