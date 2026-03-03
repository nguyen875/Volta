<?php
require_once __DIR__ . '/../services/ShopService.php';

class ShopController {
    private $shopService;

    public function __construct() {
        $this->shopService = new ShopService();
    }

    public function index() {
        $per_page = 12;
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';

        $data = $this->shopService->getPaginatedProducts($search, $category, $per_page, $current_page);

        $products = $data['products'];
        $productImages = $data['images'];
        $pagination = $data['pagination'];

        include __DIR__ . '/../views/shop/shop.php';
    }

    public function productDetail($id) {
        $data = $this->shopService->getProductDetail($id);

        if (!$data) {
            http_response_code(404);
            require_once __DIR__ . '/../views/public/404.php';
            return;
        }

        $product = $data['product'];
        $productImages = $data['images'];

        include __DIR__ . '/../views/shop/product-detail.php';
    }
}