<?php
require_once __DIR__ . '/../dao/ProductDAO.php';

class ShopService {
    private $productDAO;

    public function __construct() {
        $this->productDAO = new ProductDAO();
    }

    public function getPaginatedProducts($search, $category, $per_page, $current_page) {
        $offset = ($current_page - 1) * $per_page;
        $total_records = $this->productDAO->getTotalCount($search);
        $total_pages = ceil($total_records / $per_page);

        $allProducts = $this->productDAO->getAll($search, $per_page, $offset);

        $products = array_filter($allProducts, function($product) {
            return $product->getStatus() === 'Available';
        });

        $productImages = [];
        foreach ($products as $product) {
            $productImages[$product->getId()] = $this->productDAO->getFirstImage($product->getId());
        }

        return [
            'products' => $products,
            'images' => $productImages,
            'pagination' => [
                'current_page' => $current_page,
                'per_page' => $per_page,
                'total_records' => $total_records,
                'total_pages' => $total_pages,
                'search' => $search,
                'category' => $category
            ]
        ];
    }

    public function getProductDetail($id) {
        $product = $this->productDAO->getById($id);
        if (!$product || $product->getStatus() !== 'Available') {
            return null;
        }

        $productImages = $this->productDAO->getProductImages($id);
        return [
            'product' => $product,
            'images' => $productImages
        ];
    }
}