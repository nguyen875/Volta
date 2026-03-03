<?php
require_once __DIR__ . '/../services/ProductService.php';

class ProductController
{
    private $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $search = $_GET['search'] ?? '';
        $per_page = isset($_GET['per_page']) ? (int) $_GET['per_page'] : 10;
        $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $data = $this->productService->getPaginatedProducts($search, $per_page, $current_page);
        $products = $data['products'];
        $pagination = $data['pagination'];

        require_once __DIR__ . '/../views/admin/products/list.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $product = null;
        require_once __DIR__ . '/../views/admin/products/form.php';
    }

    public function store()
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageFile = $_FILES['image'] ?? null;

            if ($imageFile && isset($imageFile['tmp_name'])) {
                error_log("Image file details:");
                error_log("  - Name: " . ($imageFile['name'] ?? 'N/A'));
                error_log("  - Type: " . ($imageFile['type'] ?? 'N/A'));
                error_log("  - Size: " . ($imageFile['size'] ?? '0'));
                error_log("  - Error: " . ($imageFile['error'] ?? 'N/A'));
                error_log("  - Tmp: " . ($imageFile['tmp_name'] ?? 'N/A'));
                error_log("  - Tmp exists: " . (file_exists($imageFile['tmp_name']) ? 'YES' : 'NO'));
            } else {
                error_log("No image file uploaded or tmp_name missing");
            }

            $success = $this->productService->createProduct($_POST, $imageFile);

            if ($success) {
                $_SESSION['success'] = 'Product created successfully';
            } else {
                $_SESSION['error'] = 'Failed to create product';
            }

            header('Location: /volta/public/products');
            exit;
        }
    }

    public function edit($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $product = $this->productService->getProductById($id);
        if ($product) {
            require_once __DIR__ . '/../views/admin/products/form.php';
        } else
            echo "Product not found";
    }

    public function update($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageFile = $_FILES['image'] ?? null;
            $success = $this->productService->updateProduct($id, $_POST, $imageFile);

            if ($success) {
                $_SESSION['success'] = 'Product updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update product';
            }

            header('Location: /volta/public/products');
            exit;
        }
    }

    public function destroy($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        $result = $this->productService->deleteProduct($id);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Product deleted successfully' : 'Failed to delete product'
        ]);
        exit;
    }

    public function manageImages($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $product = $this->productService->getProductById($id);
        if ($product) {
            $images = $this->productService->getProductImages($id);
            require_once __DIR__ . '/../views/admin/products/images.php';
        } else
            echo "Product not found";
    }

    public function uploadImage($id)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $this->productService->addImage($id, $_FILES['image']);
        }
        header('Location: /volta/public/products/' . $id . '/images');
        exit;
    }

    public function deleteImage($productId, $imageId)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $result = $this->productService->deleteImage($imageId);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
        exit;
    }

    public function setPrimaryImage($productId, $imageId)
    {
        require_once __DIR__ . '/../helpers/Auth.php';
        Auth::requireAdmin();

        $result = $this->productService->setPrimaryImage($productId, $imageId);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
        exit;
    }
}