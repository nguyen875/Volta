<?php
// app/controllers/DiscountController.php

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/DiscountService.php';

class DiscountController
{
    private DiscountService $discountService;

    public function __construct()
    {
        $this->discountService = new DiscountService();
    }

    /**
     * GET /api/discounts?page=&limit=
     */
    public function index(): void
    {
        Auth::requireAdmin();

        $page  = max(1, (int) ($_GET['page'] ?? 1));
        $limit = max(1, (int) ($_GET['limit'] ?? 20));

        $result = $this->discountService->paginate($page, $limit);

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
     * GET /api/discounts/{id}
     */
    public function show(int $id): void
    {
        Auth::requireAdmin();

        $discount = $this->discountService->getById($id);
        if (!$discount) {
            ApiResponse::error('Discount not found.', 404);
        }

        ApiResponse::success(ApiResponse::dto($discount));
    }

    /**
     * POST /api/discounts
     * Body: { code, type, value, min_order?, uses_remaining?, expires_at? }
     */
    public function store(): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();

        try {
            $id = $this->discountService->create($data);
            $discount = $this->discountService->getById($id);

            ApiResponse::success(
                $discount ? ApiResponse::dto($discount) : ['id' => $id],
                'Discount created successfully.',
                201
            );
        } catch (\InvalidArgumentException $e) {
            ApiResponse::error($e->getMessage(), 422);
        } catch (\RuntimeException $e) {
            ApiResponse::error($e->getMessage(), 409);
        }
    }

    /**
     * PUT /api/discounts/{id}
     * Body: { code?, type?, value?, min_order?, uses_remaining?, expires_at? }
     */
    public function update(int $id): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();
        $this->discountService->update($id, $data);

        $discount = $this->discountService->getById($id);
        if (!$discount) {
            ApiResponse::error('Discount not found.', 404);
        }

        ApiResponse::success(ApiResponse::dto($discount), 'Discount updated successfully.');
    }

    /**
     * DELETE /api/discounts/{id}
     */
    public function destroy(int $id): void
    {
        Auth::requireAdmin();

        $affected = $this->discountService->delete($id);
        if ($affected === 0) {
            ApiResponse::error('Discount not found.', 404);
        }

        ApiResponse::success(null, 'Discount deleted successfully.');
    }

    /**
     * GET /api/discounts/valid
     * Public or authenticated - get currently valid discounts.
     */
    public function valid(): void
    {
        $discounts = $this->discountService->getValid();
        ApiResponse::success(ApiResponse::dtoList($discounts));
    }
}
