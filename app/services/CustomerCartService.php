<?php
require_once __DIR__ . '/../dao/ProductDAO.php';
require_once __DIR__ . '/../dao/DiscountDAO.php';
require_once __DIR__ . '/../../config/db.php';

class CustomerCartService {
    private $productDAO;
    private $discountDAO;
    private $conn;
    
    public function __construct() {
        $this->productDAO = new ProductDAO();
        $this->discountDAO = new DiscountDAO();
        $database = new Database();
        $this->conn = $database->conn;
    }
    
    /**
     * Get cart items with product details
     */
    public function getCartItems($cartSession) {
        $products = [];
        $subtotal = 0;
        
        foreach ($cartSession as $productId => $quantity) {
            $product = $this->productDAO->getById($productId);
            if ($product) {
                $price = $product->getPrice();
                $discount = $product->getDiscountRate();
                $finalPrice = $price * (1 - $discount / 100);
                
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount' => $discount,
                    'finalPrice' => $finalPrice,
                    'totalPrice' => $finalPrice * $quantity
                ];
                
                $subtotal += $finalPrice * $quantity;
            }
        }
        
        return ['products' => $products, 'subtotal' => $subtotal];
    }
    
    /**
     * Add product to cart
     */
    public function addToCart($productId, $quantity, &$cartSession) {
        // Validate product exists
        $product = $this->productDAO->getById($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }
        
        // Check stock
        $currentQuantity = $cartSession[$productId] ?? 0;
        $newQuantity = $currentQuantity + $quantity;
        
        if ($newQuantity > $product->getQuantity()) {
            return ['success' => false, 'message' => 'Not enough stock'];
        }
        
        // Add to cart
        $cartSession[$productId] = $newQuantity;
        
        // Calculate cart count
        $cartCount = array_sum($cartSession);
        
        return [
            'success' => true,
            'message' => 'Product added to cart',
            'cartCount' => $cartCount
        ];
    }
    
    /**
     * Update cart item quantity
     */
    public function updateCartItem($productId, $quantity, &$cartSession) {
        // Validate product exists
        $product = $this->productDAO->getById($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }
        
        // Check stock
        if ($quantity > $product->getQuantity()) {
            return ['success' => false, 'message' => 'Not enough stock'];
        }
        
        // Update quantity or remove if 0
        if ($quantity > 0) {
            $cartSession[$productId] = $quantity;
        } else {
            unset($cartSession[$productId]);
        }
        
        // Calculate new totals
        $price = $product->getPrice();
        $discount = $product->getDiscountRate();
        $finalPrice = $price * (1 - $discount / 100);
        $itemTotal = $finalPrice * $quantity;
        
        // Calculate cart subtotal
        $subtotal = $this->calculateSubtotal($cartSession);
        $cartCount = array_sum($cartSession);
        
        return [
            'success' => true,
            'itemTotal' => $itemTotal,
            'subtotal' => $subtotal,
            'cartCount' => $cartCount
        ];
    }
    
    /**
     * Remove product from cart
     */
    public function removeFromCart($productId, &$cartSession) {
        unset($cartSession[$productId]);
        
        $subtotal = $this->calculateSubtotal($cartSession);
        $cartCount = array_sum($cartSession);
        
        return [
            'success' => true,
            'subtotal' => $subtotal,
            'cartCount' => $cartCount
        ];
    }
    
    /**
     * Calculate cart subtotal
     */
    private function calculateSubtotal($cartSession) {
        $subtotal = 0;
        foreach ($cartSession as $id => $qty) {
            $product = $this->productDAO->getById($id);
            if ($product) {
                $price = $product->getPrice();
                $discount = $product->getDiscountRate();
                $subtotal += $price * (1 - $discount / 100) * $qty;
            }
        }
        return $subtotal;
    }
    
    /**
     * Get checkout data
     */
    public function getCheckoutData($cartSession) {
        if (empty($cartSession)) {
            return null;
        }
        
        $products = [];
        $subtotal = 0;
        
        foreach ($cartSession as $productId => $quantity) {
            $product = $this->productDAO->getById($productId);
            if ($product) {
                $price = $product->getPrice();
                $discount = $product->getDiscountRate();
                $finalPrice = $price * (1 - $discount / 100);
                
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'finalPrice' => $finalPrice,
                    'totalPrice' => $finalPrice * $quantity
                ];
                
                $subtotal += $finalPrice * $quantity;
            }
        }
        
        // Get available discount coupons
        $discounts = $this->discountDAO->getAll();
        $activeDiscounts = array_filter($discounts, function($d) {
            return $d->getStatus() === 'Activate' && $d->getQuantity() > 0;
        });
        
        return [
            'products' => $products,
            'subtotal' => $subtotal,
            'discounts' => $activeDiscounts
        ];
    }
    
    /**
     * Apply discount coupon
     */
    public function applyDiscount($discountCode, $subtotal) {
        if (empty($discountCode)) {
            return ['success' => false, 'message' => 'Please enter a discount code'];
        }
        
        // Get discount from database
        $discount = $this->discountDAO->getByCode($discountCode);
        
        if (!$discount) {
            return ['success' => false, 'message' => 'Invalid discount code'];
        }
        
        if ($discount->getStatus() !== 'Activate') {
            return ['success' => false, 'message' => 'This discount code is not active'];
        }
        
        if ($discount->getQuantity() <= 0) {
            return ['success' => false, 'message' => 'This discount code is no longer available'];
        }
        
        // Check condition
        $condition = $discount->getCondition();
        
        // Parse numeric conditions like "> 200000", "< 500000"
        if (preg_match('/^>\s*(\d+)$/', $condition, $matches)) {
            $minAmount = floatval($matches[1]);
            if ($subtotal <= $minAmount) {
                return [
                    'success' => false,
                    'message' => "Minimum order amount must be greater than " . number_format($minAmount, 0, ',', '.') . " ₫"
                ];
            }
        } elseif (preg_match('/^<\s*(\d+)$/', $condition, $matches)) {
            $maxAmount = floatval($matches[1]);
            if ($subtotal >= $maxAmount) {
                return [
                    'success' => false,
                    'message' => "Maximum order amount must be less than " . number_format($maxAmount, 0, ',', '.') . " ₫"
                ];
            }
        }
        
        $discountAmount = floatval($discount->getMoneyDeduct());
        $total = max(0, $subtotal - $discountAmount);
        
        return [
            'success' => true,
            'discountAmount' => $discountAmount,
            'total' => $total,
            'discountCode' => $discountCode
        ];
    }
    
    /**
     * Place order
     */
    public function placeOrder($orderData, $cartSession) {
        if (empty($cartSession)) {
            return ['success' => false, 'message' => 'Cart is empty'];
        }
        
        // Validate required fields
        if (empty($orderData['customer_name']) || empty($orderData['customer_phone']) || empty($orderData['customer_address'])) {
            return ['success' => false, 'message' => 'Please fill in all required fields'];
        }
        
        try {
            // Start transaction
            $this->conn->begin_transaction();
            
            // 1. Create or get customer
            $customerId = $this->createOrGetCustomer(
                $orderData['customer_name'],
                $orderData['customer_phone'],
                $orderData['customer_address']
            );
            
            // 2. Create order
            $orderId = $this->createOrder(
                $customerId,
                $orderData['subtotal'],
                $orderData['discount_code'],
                $orderData['customer_phone'],
                $orderData['customer_address'],
                $orderData['customer_name'],
                $orderData['payment_method'],
                $orderData['total']
            );
            
            // 3. Add order items and update stock
            $this->addOrderItems($orderId, $cartSession);
            
            // 4. Update discount quantity if used
            if (!empty($orderData['discount_code'])) {
                $this->updateDiscountQuantity($orderData['discount_code']);
            }
            
            // Commit transaction
            $this->conn->commit();
            
            return [
                'success' => true,
                'message' => 'Order placed successfully',
                'orderId' => $orderId
            ];
            
        } catch (Exception $e) {
            // Rollback on error
            $this->conn->rollback();
            error_log("Place order error: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Create or get customer
     */
    private function createOrGetCustomer($name, $phone, $address) {
        // Check if customer exists by phone
        $sql = "SELECT l.UID FROM LOGIN l 
                INNER JOIN CUSTOMER k ON l.UID = k.UID 
                WHERE k.PhoneNum = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Existing customer
            $customerId = $row['UID'];
            
            // Update customer info
            $updateSql = "UPDATE CUSTOMER SET Address = ? WHERE UID = ?";
            $updateStmt = $this->conn->prepare($updateSql);
            $updateStmt->bind_param("si", $address, $customerId);
            $updateStmt->execute();
            
            return $customerId;
        } else {
            // New guest customer
            $email = 'guest_' . time() . '@guest.com';
            $password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
            $role = 'Customer';
            
            $loginSql = "INSERT INTO LOGIN (Email, Password, Role, Name, Avatar) VALUES (?, ?, ?, ?, NULL)";
            $loginStmt = $this->conn->prepare($loginSql);
            $loginStmt->bind_param("ssss", $email, $password, $role, $name);
            $loginStmt->execute();
            $customerId = $this->conn->insert_id;
            
            // Create CUSTOMER entry
            $customerSql = "INSERT INTO CUSTOMER (UID, PhoneNum, Address, Status) VALUES (?, ?, ?, 'Active')";
            $customerStmt = $this->conn->prepare($customerSql);
            $customerStmt->bind_param("iss", $customerId, $phone, $address);
            $customerStmt->execute();
            
            return $customerId;
        }
    }
    
    /**
     * Create order in database
     */
    private function createOrder($customerId, $subtotal, $discountCode, $phone, $address, $receiverName, $paymentMethod, $total) {
        $orderDate = date('Y-m-d H:i:s');
        $status = 'Pending';
        $transaction = 'Unpaid';
        
        $sql = "INSERT INTO `ORDER` 
                (UID, OrderDate, Total, DiscountCoupon, Status, PhoneNum, Address, Transaction, ReceiverName, PaymentMethod, Bill) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isdsssssssd",
            $customerId,
            $orderDate,
            $subtotal,
            $discountCode,
            $status,
            $phone,
            $address,
            $transaction,
            $receiverName,
            $paymentMethod,
            $total
        );
        $stmt->execute();
        
        return $this->conn->insert_id;
    }
    
    /**
     * Add order items and update product stock
     */
    private function addOrderItems($orderId, $cartSession) {
        foreach ($cartSession as $productId => $quantity) {
            // Insert into CONTAIN
            $sql = "INSERT INTO CONTAIN (Order_ID, Product_ID, Quantity) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $orderId, $productId, $quantity);
            $stmt->execute();
            
            // Update product stock
            $stockSql = "UPDATE PRODUCT SET Quantity = Quantity - ? WHERE Product_ID = ?";
            $stockStmt = $this->conn->prepare($stockSql);
            $stockStmt->bind_param("ii", $quantity, $productId);
            $stockStmt->execute();
        }
    }
    
    /**
     * Update discount quantity
     */
    private function updateDiscountQuantity($discountCode) {
        $sql = "UPDATE DISCOUNT_COUPON SET Quantity = Quantity - 1 WHERE Code = ? AND Quantity > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $discountCode);
        $stmt->execute();
    }
    
    /**
     * Get order details
     */
    public function getOrderDetails($orderId) {
        $sql = "SELECT * FROM `ORDER` WHERE Order_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
}
