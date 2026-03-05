<?php
// app/controllers/BundleController.php

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/BundleService.php';

class BundleController
{
    private BundleService $bundleService;

    public function __construct()
    {
        $this->bundleService = new BundleService();
    }

    /**
     * GET /api/bundles?page=&limit=
     */
    public function index(): void
    {
        $page  = max(1, (int) ($_GET['page'] ?? 1));
        $limit = max(1, (int) ($_GET['limit'] ?? 20));

        $result = $this->bundleService->paginate($page, $limit);

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
     * GET /api/bundles/active
     */
    public function active(): void
    {
        $bundles = $this->bundleService->getActive();
        ApiResponse::success(ApiResponse::dtoList($bundles));
    }

    /**
     * GET /api/bundles/{id}
     */
    public function show(int $id): void
    {
        $data = $this->bundleService->getWithItems($id);
        if (!$data) {
            ApiResponse::error('Bundle not found.', 404);
        }

        ApiResponse::success([
            'bundle' => ApiResponse::dto($data['bundle']),
            'items'  => ApiResponse::dtoList($data['items']),
        ]);
    }

    /**
     * POST /api/bundles
     * Body: { name, description?, bundle_price, is_active?, product_ids?: int[] }
     */
    public function store(): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();

        try {
            $id = $this->bundleService->create($data);

            // Sync items if provided
            if (!empty($data['product_ids']) && is_array($data['product_ids'])) {
                $this->bundleService->syncItems($id, $data['product_ids']);
            }

            $bundle = $this->bundleService->getWithItems($id);

            ApiResponse::success(
                $bundle ? [
                    'bundle' => ApiResponse::dto($bundle['bundle']),
                    'items'  => ApiResponse::dtoList($bundle['items']),
                ] : ['id' => $id],
                'Bundle created successfully.',
                201
            );
        } catch (\InvalidArgumentException $e) {
            ApiResponse::error($e->getMessage(), 422);
        }
    }

    /**
     * PUT /api/bundles/{id}
     * Body: { name?, description?, bundle_price?, is_active?, product_ids?: int[] }
     */
    public function update(int $id): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();

        $this->bundleService->update($id, $data);

        // Sync items if provided
        if (isset($data['product_ids']) && is_array($data['product_ids'])) {
            $this->bundleService->syncItems($id, $data['product_ids']);
        }

        $bundle = $this->bundleService->getWithItems($id);
        if (!$bundle) {
            ApiResponse::error('Bundle not found.', 404);
        }

        ApiResponse::success([
            'bundle' => ApiResponse::dto($bundle['bundle']),
            'items'  => ApiResponse::dtoList($bundle['items']),
        ], 'Bundle updated successfully.');
    }

    /**
     * DELETE /api/bundles/{id}
     */
    public function destroy(int $id): void
    {
        Auth::requireAdmin();

        $affected = $this->bundleService->delete($id);
        if ($affected === 0) {
            ApiResponse::error('Bundle not found.', 404);
        }

        ApiResponse::success(null, 'Bundle deleted successfully.');
    }

    // ══════════════════════════════════════════════════════════
    //  BUNDLE ITEMS
    // ══════════════════════════════════════════════════════════

    /**
     * GET /api/bundles/{id}/items
     */
    public function items(int $bundleId): void
    {
        $items = $this->bundleService->getItems($bundleId);
        ApiResponse::success(ApiResponse::dtoList($items));
    }

    /**
     * POST /api/bundles/{id}/items
     * Body: { product_id }
     */
    public function addItem(int $bundleId): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();
        $productId = (int) ($data['product_id'] ?? 0);

        if ($productId <= 0) {
            ApiResponse::error('Invalid product ID.', 422);
        }

        $id = $this->bundleService->addItem($bundleId, $productId);
        ApiResponse::success(['id' => $id], 'Item added to bundle.', 201);
    }

    /**
     * DELETE /api/bundles/{bundleId}/items/{itemId}
     */
    public function removeItem(int $bundleId, int $itemId): void
    {
        Auth::requireAdmin();

        $affected = $this->bundleService->removeItem($itemId);
        if ($affected === 0) {
            ApiResponse::error('Item not found.', 404);
        }

        ApiResponse::success(null, 'Item removed from bundle.');
    }
}
