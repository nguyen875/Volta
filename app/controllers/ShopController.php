<?php
// app/controllers/ShopController.php
// Public storefront endpoints

require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/ShopService.php';

class ShopController
{
    private ShopService $shopService;

    public function __construct()
    {
        $this->shopService = new ShopService();
    }

    /**
     * GET /api/shop/products?page=&limit=&category_id=&search=
     */
    public function index(): void
    {
        $page       = max(1, (int) ($_GET['page'] ?? 1));
        $limit      = max(1, min(60, (int) ($_GET['limit'] ?? 12)));
        $categoryId = isset($_GET['category_id']) ? (int) $_GET['category_id'] : null;
        $search     = $_GET['search'] ?? null;

        $result = $this->shopService->getProducts($page, $limit, $categoryId, $search);

        // Serialize images map
        $imagesMap = [];
        foreach ($result['images'] as $productId => $imgDto) {
            $imagesMap[$productId] = $imgDto ? ApiResponse::dto($imgDto) : null;
        }

        ApiResponse::paginated(
            ApiResponse::dtoList($result['data']),
            [
                'page'   => $result['page'],
                'limit'  => $result['limit'],
                'total'  => $result['total'],
                'images' => $imagesMap,
            ]
        );
    }

    /**
     * GET /api/shop/products/slug/{slug}
     */
    public function showBySlug(string $slug): void
    {
        $data = $this->shopService->getProductDetailBySlug($slug);
        if (!$data) {
            ApiResponse::error('Product not found.', 404);
        }

        ApiResponse::success([
            'product' => ApiResponse::dto($data['product']),
            'images'  => ApiResponse::dtoList($data['images']),
        ]);
    }

    /**
     * GET /api/shop/products/{id}
     */
    public function show(int $id): void
    {
        $data = $this->shopService->getProductDetail($id);
        if (!$data) {
            ApiResponse::error('Product not found.', 404);
        }

        ApiResponse::success([
            'product' => ApiResponse::dto($data['product']),
            'images'  => ApiResponse::dtoList($data['images']),
        ]);
    }

    /**
     * GET /api/shop/categories
     */
    public function categories(): void
    {
        $categories = $this->shopService->getCategories();
        ApiResponse::success(ApiResponse::dtoList($categories));
    }

    /**
     * GET /api/shop/featured?badge=&limit=
     */
    public function featured(): void
    {
        $badge = $_GET['badge'] ?? 'hot';
        $limit = max(1, min(50, (int) ($_GET['limit'] ?? 8)));

        $products = $this->shopService->getFeatured($badge, $limit);
        ApiResponse::success(ApiResponse::dtoList($products));
    }
}
