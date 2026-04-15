<?php
// app/controllers/ProductController.php

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/ProductService.php';

class ProductController
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * GET /api/products?search=&page=&limit=
     */
    public function index(): void
    {
        Auth::requireAdmin();

        $search = $_GET['search'] ?? '';
        $page   = max(1, (int) ($_GET['page'] ?? 1));
        $limit  = max(1, (int) ($_GET['limit'] ?? 20));

        if ($search !== '') {
            $result = $this->productService->search($search, $page, $limit);
        } else {
            $result = $this->productService->paginate($page, $limit);
        }

        ApiResponse::paginated(
            ApiResponse::dtoList($result['data']),
            [
                'page'  => $result['page'],
                'limit' => $result['limit'],
                'total' => $result['total'],
            ]
        );
    }

    /**
     * GET /api/products/{id}
     */
    public function show(int $id): void
    {
        Auth::requireAdmin();

        $product = $this->productService->getById($id);
        if (!$product) {
            ApiResponse::error('Product not found.', 404);
        }

        $images = $this->productService->getImages($id);

        ApiResponse::success([
            'product' => ApiResponse::dto($product),
            'images'  => ApiResponse::dtoList($images),
        ]);
    }

    /**
     * POST /api/products
     * Body (form-data): { name, slug?, category_id, description, price, stock, badge?, is_active?, image? }
     */
    public function store(): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();

        try {
            $id = $this->productService->create($data);

            // Handle image upload if present
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $this->productService->uploadImage($id, $_FILES['image']);
            }

            $product = $this->productService->getById($id);

            ApiResponse::success(
                $product ? ApiResponse::dto($product) : ['id' => $id],
                'Product created successfully.',
                201
            );
        } catch (\Exception $e) {
            ApiResponse::error($e->getMessage(), 422);
        }
    }

    /**
     * PUT /api/products/{id}
     * Body: { name?, slug?, category_id?, description?, price?, stock?, badge?, is_active? }
     */
    public function update(int $id): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();
        $this->productService->update($id, $data);

        // Handle image upload if present (for multipart PUT)
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $this->productService->uploadImage($id, $_FILES['image']);
        }

        $product = $this->productService->getById($id);
        if (!$product) {
            ApiResponse::error('Product not found.', 404);
        }

        ApiResponse::success(ApiResponse::dto($product), 'Product updated successfully.');
    }

    /**
     * DELETE /api/products/{id}
     */
    public function destroy(int $id): void
    {
        Auth::requireAdmin();

        $affected = $this->productService->delete($id);
        if ($affected === 0) {
            ApiResponse::error('Product not found.', 404);
        }

        ApiResponse::success(null, 'Product deleted successfully.');
    }

    // ══════════════════════════════════════════════════════════
    //  PRODUCT IMAGES
    // ══════════════════════════════════════════════════════════

    /**
     * GET /api/products/{id}/images
     */
    public function images(int $productId): void
    {
        Auth::requireAdmin();

        $images = $this->productService->getImages($productId);
        ApiResponse::success(ApiResponse::dtoList($images));
    }

    /**
     * POST /api/products/{id}/images
     * Body (form-data): { image }
     */
    public function uploadImage(int $productId): void
    {
        Auth::requireAdmin();

        if (!isset($_FILES['image'])) {
            ApiResponse::error('No image file provided.', 422);
        }

        $imageId = $this->productService->uploadImage($productId, $_FILES['image']);
        if ($imageId === false) {
            ApiResponse::error('Failed to upload image. Check file type and size (max 5MB).', 422);
        }

        ApiResponse::success(['id' => $imageId], 'Image uploaded successfully.', 201);
    }

    /**
     * DELETE /api/products/{productId}/images/{imageId}
     */
    public function deleteImage(int $productId, int $imageId): void
    {
        Auth::requireAdmin();

        $affected = $this->productService->deleteImage($imageId);
        if ($affected === 0) {
            ApiResponse::error('Image not found.', 404);
        }

        ApiResponse::success(null, 'Image deleted successfully.');
    }

    /**
     * PUT /api/products/{productId}/images/{imageId}/primary
     */
    public function setPrimaryImage(int $productId, int $imageId): void
    {
        Auth::requireAdmin();

        $this->productService->setPrimaryImage($productId, $imageId);
        ApiResponse::success(null, 'Primary image updated.');
    }

    // ══════════════════════════════════════════════════════════
    //  PRODUCT RELATIONS
    // ══════════════════════════════════════════════════════════

    /**
     * GET /api/products/{id}/relations?type=upsell|crosssell
     */
    public function relations(int $productId): void
    {
        $type = $_GET['type'] ?? 'crosssell';

        if ($type === 'upsell') {
            $relations = $this->productService->getUpsells($productId);
        } else {
            $relations = $this->productService->getCrossSells($productId);
        }

        ApiResponse::success(ApiResponse::dtoList($relations));
    }

    /**
     * POST /api/products/{id}/relations
     * Body: { related_id, type?, discount_amount?, sort_order? }
     */
    public function addRelation(int $productId): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();
        $data['product_id'] = $productId;

        try {
            $id = $this->productService->addRelation($data);
            ApiResponse::success(['id' => $id], 'Relation added successfully.', 201);
        } catch (\Exception $e) {
            ApiResponse::error($e->getMessage(), 422);
        }
    }

    /**
     * DELETE /api/products/{productId}/relations/{relationId}
     */
    public function removeRelation(int $productId, int $relationId): void
    {
        Auth::requireAdmin();

        $affected = $this->productService->removeRelation($relationId);
        if ($affected === 0) {
            ApiResponse::error('Relation not found.', 404);
        }

        ApiResponse::success(null, 'Relation removed successfully.');
    }
}
