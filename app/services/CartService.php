<?php
require_once __DIR__ . '/../dao/CartDAO.php';

class CartService {
    private $cartDAO;

    public function __construct() {
        $this->cartDAO = new CartDAO();
    }

    public function getOrdersWithStats($startDate, $endDate, $perPage, $page) {
        $offset = ($page - 1) * $perPage;
        $totalOrders = $this->cartDAO->getTotalCount($startDate, $endDate);
        $totalPages = ceil($totalOrders / $perPage);
        $orders = $this->cartDAO->getAll($startDate, $endDate, $perPage, $offset);
        $stats = $this->cartDAO->calculateTotalProfit($startDate, $endDate);
        $statusStats = $this->cartDAO->getStatsByStatus($startDate, $endDate);

        return [
            'orders' => $orders,
            'stats' => $stats,
            'statusStats' => $statusStats,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'per_page' => $perPage,
                'total_records' => $totalOrders
            ]
        ];
    }

    public function getOrderById($id) {
        $order = $this->cartDAO->getById($id);
        if (!$order) throw new Exception('Order not found');
        $items = $this->cartDAO->getOrderItems($id);
        return ['order' => $order, 'items' => $items];
    }

    public function getOrderForEdit($id) {
        $order = $this->cartDAO->getById($id);
        if (!$order) throw new Exception('Order not found');
        return $order;
    }

    public function updateOrderStatus($id, $paymentStatus, $orderStatus) {
        $validPaymentStatuses = ['Unpaid', 'Paid'];
        $validOrderStatuses = ['Pending', 'Confirmed', 'Shipping', 'Delivered', 'Cancelled'];

        if (!in_array($paymentStatus, $validPaymentStatuses) || !in_array($orderStatus, $validOrderStatuses)) {
            throw new Exception('Invalid status values');
        }

        return $this->cartDAO->updateStatus($id, $paymentStatus, $orderStatus);
    }
}
