<?php
require_once __DIR__ . '/../services/CustomerCartService.php';

class CustomerCartController
{
    private $cartService;

    public function __construct()
    {
        $this->cartService = new CustomerCartService();
    }

    /**
     * Display cart page
     */
    public function index()
    {
        // Cart page
        include __DIR__ . '/../views/shop/cart.php';
    }

    /**
     * Add product to cart (AJAX)
     */
    public function add()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = intval($_POST['product_id'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 1);

            if ($productId > 0 && $quantity > 0) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = $quantity;
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Product added to cart',
                    'cartCount' => array_sum($_SESSION['cart'])
                ]);
                exit;
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid product or quantity'
                ]);
                exit;
            }
        }

        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
        exit;
    }

    /**
     * Update cart quantity (AJAX)
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = intval($_POST['product_id'] ?? 0);
            $action = $_POST['action'] ?? '';

            if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
                if ($action === 'increase') {
                    $_SESSION['cart'][$productId]++;
                } elseif ($action === 'decrease') {
                    $_SESSION['cart'][$productId]--;
                    if ($_SESSION['cart'][$productId] <= 0) {
                        unset($_SESSION['cart'][$productId]);
                    }
                }
            }
        }

        header('Location: /volta/public/cart');
        exit;
    }

    /**
     * Remove product from cart (AJAX)
     */
    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = intval($_POST['product_id'] ?? 0);

            if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                $_SESSION['success'] = 'Product removed from cart';
            }
        }

        header('Location: /volta/public/cart');
        exit;
    }

    /**
     * Display checkout/bill page
     */
    public function checkout()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireLogin();

        require_once __DIR__ . '/../dao/CustomerDAO.php';
        $customerDAO = new CustomerDAO();

        require_once __DIR__ . '/../dao/DiscountDAO.php';
        $discountDAO = new DiscountDAO();

        // Get customer's default info (will be null if not set)
        $customer = $customerDAO->getByUserId($_SESSION['UID']);

        // Get active discount coupons
        $activeDiscounts = $discountDAO->getActiveDiscounts();

        // Pass to checkout view
        include __DIR__ . '/../views/shop/checkout.php';
    }

    /**
     * Apply discount coupon (AJAX)
     */
    public function applyDiscount()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $discountCode = $_POST['discount_code'] ?? '';
        $subtotal = $_POST['subtotal'] ?? 0;

        $result = $this->cartService->applyDiscount($discountCode, $subtotal);
        echo json_encode($result);
    }

    /**
     * Place order and save to database
     */
    public function placeOrder()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /volta/public/checkout');
            exit;
        }

        // Get form data
        $receiverName = trim($_POST['receiver_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? 'COD';
        $discountCode = trim($_POST['discount_code'] ?? '');

        // Validate required fields
        if (empty($receiverName) || empty($phone) || empty($address)) {
            $_SESSION['error'] = 'Please fill in all required fields';
            header('Location: /volta/public/checkout');
            exit;
        }

        // Check if cart is empty
        if (empty($_SESSION['cart'])) {
            $_SESSION['error'] = 'Your cart is empty';
            header('Location: /volta/public/cart');
            exit;
        }

        try {
            require_once __DIR__ . '/../../config/database.php';
            require_once __DIR__ . '/../dao/ProductDAO.php';
            require_once __DIR__ . '/../dao/DiscountDAO.php';

            $db = getDB();
            $productDAO = new ProductDAO();
            $discountDAO = new DiscountDAO();

            // Calculate totals
            $subtotal = 0;
            $cartItems = [];

            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $product = $productDAO->getById($productId);
                if (!$product)
                    continue;

                // Check stock
                if ($product->getQuantity() < $quantity) {
                    $_SESSION['error'] = "Not enough stock for: {$product->getProductName()}";
                    header('Location: /volta/public/cart');
                    exit;
                }

                $price = $product->getPrice() * (1 - $product->getDiscountRate() / 100);
                $itemTotal = $price * $quantity;
                $subtotal += $itemTotal;

                $cartItems[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price
                ];
            }

            // Apply discount if provided
            $discountAmount = 0;
            $discountCoupon = null;

            if (!empty($discountCode)) {
                $discount = $discountDAO->getByCode($discountCode);
                if ($discount && $discount->getStatus() === 'Activate' && $discount->getQuantity() > 0) {
                    $discountAmount = $discount->getMoneyDeduct();
                    $discountCoupon = $discountCode;
                }
            }

            $total = $subtotal;
            $bill = max(0, $subtotal - $discountAmount);

            // Start transaction
            $db->beginTransaction();

            // Insert order
            $orderDate = date('d-m-Y');
            $sql = "INSERT INTO `ORDER` (UID, OrderDate, Total, DiscountCoupon, Status, PhoneNum, Address, ReceiverName, Transaction, PaymentMethod, Bill) 
                    VALUES (?, ?, ?, ?, 'Pending', ?, ?, ?, 'Unpaid', ?, ?)";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                $_SESSION['UID'],
                $orderDate,
                $total,
                $discountCoupon,
                $phone,
                $address,
                $receiverName,
                $paymentMethod,
                $bill
            ]);

            $orderId = $db->lastInsertId();

            // Insert order items and update stock
            foreach ($cartItems as $item) {
                // Insert into CONTAIN
                $sql = "INSERT INTO CONTAIN (Order_ID, Product_ID, Quantity) VALUES (?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$orderId, $item['product_id'], $item['quantity']]);

                // Update product quantity
                $sql = "UPDATE PRODUCT SET Quantity = Quantity - ? WHERE Product_ID = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$item['quantity'], $item['product_id']]);
            }

            // Update discount quantity if used
            if ($discountCoupon) {
                $sql = "UPDATE DISCOUNT_COUPON SET Quantity = Quantity - 1 WHERE Code = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$discountCoupon]);
            }

            $db->commit();

            // Clear cart
            unset($_SESSION['cart']);

            // Redirect to success page
            $_SESSION['success'] = 'Order placed successfully!';
            header("Location: /volta/public/order-success/$orderId");
            exit;

        } catch (Exception $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            error_log("Place order error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to place order. Please try again.';
            header('Location: /volta/public/checkout');
            exit;
        }
    }

    /**
     * Display order success page
     */
    public function orderSuccess($orderId)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireLogin();

        require_once __DIR__ . '/../dao/CartDAO.php';
        $cartDAO = new CartDAO();

        $order = $cartDAO->getById($orderId);

        // Verify order belongs to user
        if (!$order || $order['UID'] != $_SESSION['UID']) {
            header('Location: /volta/public/');
            exit;
        }

        $orderItems = $cartDAO->getOrderItems($orderId);

        include __DIR__ . '/../views/shop/order_success.php';
    }
}
