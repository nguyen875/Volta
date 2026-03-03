<?php
require_once __DIR__ . '/../../config/database.php';

class CartDAO {
    private $db;
    
    public function __construct() {
        $this->db = getDB(); // PDO instance
    }
    
    /**
     * Get total count of orders with optional date filter
     */
    public function getTotalCount($startDate = null, $endDate = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM `ORDER` od";
            $params = [];
            $conditions = [];
            
            if ($startDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') >= :startDate";
                $params[':startDate'] = $startDate;
            }
            
            if ($endDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') <= :endDate";
                $params[':endDate'] = $endDate;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return (int)($row['total'] ?? 0);
        } catch (Exception $e) {
            error_log("CartDAO getTotalCount error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get all orders with optional date filter and pagination
     */
    public function getAll($startDate = null, $endDate = null, $limit = 10, $offset = 0) {
        try {
            $sql = "SELECT 
                        od.Order_ID,
                        od.UID,
                        l.Name as CustomerName,
                        l.Email,
                        od.OrderDate,
                        od.Total,
                        od.DiscountCoupon,
                        od.Status,
                        od.Transaction,
                        od.PaymentMethod,
                        od.Bill,
                        od.ReceiverName,
                        od.PhoneNum,
                        od.Address
                    FROM `ORDER` od
                    LEFT JOIN LOGIN l ON od.UID = l.UID";
            
            $params = [];
            $conditions = [];
            
            if ($startDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') >= :startDate";
                $params[':startDate'] = $startDate;
            }
            
            if ($endDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') <= :endDate";
                $params[':endDate'] = $endDate;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $sql .= " ORDER BY od.Order_ID DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->db->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("CartDAO getAll error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get order details by ID
     */
    public function getById($id) {
        try {
            $sql = "SELECT 
                        od.Order_ID,
                        od.UID,
                        l.Name as CustomerName,
                        l.Email,
                        od.OrderDate,
                        od.Total,
                        od.DiscountCoupon,
                        od.Status,
                        od.Transaction,
                        od.PaymentMethod,
                        od.Bill,
                        od.ReceiverName,
                        od.PhoneNum,
                        od.Address
                    FROM `ORDER` od
                    LEFT JOIN LOGIN l ON od.UID = l.UID
                    WHERE od.Order_ID = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("CartDAO getById error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get order items (products in the order)
     */
    public function getOrderItems($orderId) {
        try {
            $sql = "SELECT 
                        g.Product_ID,
                        sp.ProductName,
                        sp.Price,
                        sp.DiscountRate,
                        g.Quantity,
                        (sp.Price * (1 - sp.DiscountRate / 100)) as PriceAfterDiscount,
                        (g.Quantity * sp.Price * (1 - sp.DiscountRate / 100)) as FinalTotal
                    FROM CONTAIN g
                    JOIN PRODUCT sp ON g.Product_ID = sp.Product_ID
                    WHERE g.Order_ID = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("CartDAO getOrderItems error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Calculate total profit from all orders or filtered by date
     */
    public function calculateTotalProfit($startDate = null, $endDate = null) {
        try {
            $sql = "SELECT 
                        SUM(od.Bill) as TotalRevenue,
                        COUNT(od.Order_ID) as TotalOrders,
                        SUM(CASE WHEN od.Status = 'Delivered' THEN 1 ELSE 0 END) as CompletedOrders,
                        SUM(CASE WHEN od.Status = 'Cancelled' THEN 1 ELSE 0 END) as CancelledOrders
                    FROM `ORDER` od";
            
            $params = [];
            $conditions = [];
            
            if ($startDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') >= :startDate";
                $params[':startDate'] = $startDate;
            }
            
            if ($endDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') <= :endDate";
                $params[':endDate'] = $endDate;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("CartDAO calculateTotalProfit error: " . $e->getMessage());
            return [
                'TotalRevenue' => 0,
                'TotalOrders' => 0,
                'CompletedOrders' => 0,
                'CancelledOrders' => 0
            ];
        }
    }
    
    /**
     * Get statistics by status
     */
    public function getStatsByStatus($startDate = null, $endDate = null) {
        try {
            $sql = "SELECT 
                        od.Status,
                        COUNT(*) as Count,
                        SUM(od.Bill) as Revenue
                    FROM `ORDER` od";
            
            $params = [];
            $conditions = [];
            
            if ($startDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') >= :startDate";
                $params[':startDate'] = $startDate;
            }
            
            if ($endDate) {
                $conditions[] = "STR_TO_DATE(od.OrderDate, '%d-%m-%Y') <= :endDate";
                $params[':endDate'] = $endDate;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $sql .= " GROUP BY od.Status";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("CartDAO getStatsByStatus error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Update order payment status and order status
     */
    public function updateStatus($orderId, $paymentStatus, $orderStatus) {
        try {
            $sql = "UPDATE `ORDER` 
                    SET Transaction = ?, Status = ? 
                    WHERE Order_ID = ?";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$paymentStatus, $orderStatus, $orderId]);
        } catch (Exception $e) {
            error_log("CartDAO updateStatus error: " . $e->getMessage());
            return false;
        }
    }
}
