<?php
require_once __DIR__ . '/../services/CartService.php';

class CartController
{
    private $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    public function index()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        $perPage = isset($_GET['per_page']) && in_array($_GET['per_page'], [10, 25, 50])
            ? (int) $_GET['per_page'] : 10;
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

        try {
            $data = $this->cartService->getOrdersWithStats($startDate, $endDate, $perPage, $page);

            $orders = $data['orders'];
            $stats = $data['stats'];
            $statusStats = $data['statusStats'];
            $pagination = $data['pagination'];

            require_once __DIR__ . '/../views/admin/carts/list.php';
        } catch (Exception $e) {
            echo "Error loading orders: " . $e->getMessage();
        }
    }

    public function view($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        try {
            $data = $this->cartService->getOrderById($id);
            $order = $data['order'];
            $items = $data['items'];
            require_once __DIR__ . '/../views/admin/carts/view.php';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function edit($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        try {
            $order = $this->cartService->getOrderForEdit($id);
            $paymentStatuses = ['Unpaid', 'Paid'];
            $orderStatuses = ['Pending', 'Confirmed', 'Shipping', 'Delivered', 'Cancelled'];
            require_once __DIR__ . '/../views/admin/carts/edit.php';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /volta/public/carts');
            exit;
        }

        $paymentStatus = $_POST['payment_status'] ?? '';
        $orderStatus = $_POST['order_status'] ?? '';

        try {
            $result = $this->cartService->updateOrderStatus($id, $paymentStatus, $orderStatus);

            $_SESSION['success'] = $result
                ? 'Order status updated successfully'
                : 'Failed to update order status';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header("Location: /volta/public/carts/view/$id");
        exit;
    }
}
