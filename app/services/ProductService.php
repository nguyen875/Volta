<?php
require_once __DIR__ . '/../dao/ProductDAO.php';
require_once __DIR__ . '/../models/Product.php';

class ProductService {
    private $productDAO;

    public function __construct() {
        $this->productDAO = new ProductDAO();
    }

    public function getPaginatedProducts($search, $per_page, $current_page) {
        if (!in_array($per_page, [10, 25, 50])) $per_page = 10;
        $offset = ($current_page - 1) * $per_page;

        $total_records = $this->productDAO->getTotalCount($search);
        $total_pages = ceil($total_records / $per_page);
        $products = $this->productDAO->getAll($search, $per_page, $offset);

        return [
            'products' => $products,
            'pagination' => [
                'current_page' => $current_page,
                'per_page' => $per_page,
                'total_records' => $total_records,
                'total_pages' => $total_pages,
                'search' => $search
            ]
        ];
    }

    public function getProductById($id) {
        return $this->productDAO->getById($id);
    }

    public function createProduct($data, $file) {
        $product = new Product(
            null,
            $data['productName'] ?? '',
            $data['description'] ?? '',
            $data['price'] ?? 0,
            $data['discountRate'] ?? 0,
            $data['quantity'] ?? 0,
            $data['publisher'] ?? '',
            $data['size'] ?? '',
            $data['pageNum'] ?? 0,
            $data['category'] ?? '',
            $data['keywords'] ?? '',
            $data['format'] ?? '',
            $data['author'] ?? '',
            $data['language'] ?? '',
            $data['yearOfPublication'] ?? 0,
            $data['status'] ?? 'Available'
        );

        if ($this->productDAO->create($product)) {
            $productId = $this->productDAO->getLastInsertId();
            
            // Upload image if provided
            if ($file && isset($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
                $this->uploadProductImage($productId, $file);
            }
            
            return true;
        }
        return false;
    }

    public function updateProduct($id, $data, $file) {
        $product = new Product(
            $id,
            $data['productName'] ?? '',
            $data['description'] ?? '',
            $data['price'] ?? 0,
            $data['discountRate'] ?? 0,
            $data['quantity'] ?? 0,
            $data['publisher'] ?? '',
            $data['size'] ?? '',
            $data['pageNum'] ?? 0,
            $data['category'] ?? '',
            $data['keywords'] ?? '',
            $data['format'] ?? '',
            $data['author'] ?? '',
            $data['language'] ?? '',
            $data['yearOfPublication'] ?? 0,
            $data['status'] ?? 'Available'
        );

        $result = $this->productDAO->update($product);
        
        // Upload new image if provided
        if ($file && isset($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
            $this->uploadProductImage($id, $file);
        }
        
        return $result;
    }

    public function deleteProduct($id) {
        return $this->productDAO->delete($id);
    }

    public function getProductImages($productId) {
        return $this->productDAO->getProductImages($productId);
    }

    public function addImage($productId, $file) {
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            return $this->uploadProductImage($productId, $file);
        }
        return false;
    }

    public function deleteImage($imageId) {
        return $this->productDAO->deleteImage($imageId);
    }

    public function setPrimaryImage($productId, $imageId) {
        return $this->productDAO->setPrimaryImage($productId, $imageId);
    }

    private function uploadProductImage($productId, $imageFile) {
        // Check if file exists
        if (!isset($imageFile['tmp_name']) || empty($imageFile['tmp_name'])) {
            error_log("ProductService: No tmp_name in imageFile");
            return false;
        }
        
        if (!file_exists($imageFile['tmp_name'])) {
            error_log("ProductService: Temp file does not exist");
            return false;
        }
        
        // Validate file type - WEBP SUPPORTED
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
        $fileType = mime_content_type($imageFile['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
            error_log("ProductService: Invalid file type: $fileType");
            return false;
        }
        
        // Validate file size (5MB max)
        if ($imageFile['size'] > 5 * 1024 * 1024) {
            error_log("ProductService: File too large: " . $imageFile['size']);
            return false;
        }
        
        // Create product-specific directory
        $uploadDir = __DIR__ . '/../../public/image/product/' . $productId . '/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                error_log("ProductService: Failed to create directory: $uploadDir");
                return false;
            }
        }
        
        // Generate unique filename
        $extension = strtolower(pathinfo($imageFile['name'], PATHINFO_EXTENSION));
        if (empty($extension)) {
            $mimeToExt = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];
            $extension = $mimeToExt[$fileType] ?? 'jpg';
        }
        
        $filename = uniqid('img_') . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($imageFile['tmp_name'], $filepath)) {
            // Save relative path to database
            $relativePath = 'public/image/product/' . $productId . '/' . $filename;
            
            if ($this->productDAO->addImage($productId, $relativePath)) {
                return true;
            } else {
                error_log("ProductService: Failed to save image to database");
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                return false;
            }
        } else {
            error_log("ProductService: Failed to move uploaded file");
            return false;
        }
    }
}