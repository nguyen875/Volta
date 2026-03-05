<?php
// app/controllers/CategoryController.php

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/CategoryService.php';

class CategoryController
{
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * GET /api/categories?page=&limit=
     */
    public function index(): void
    {
        $page  = max(1, (int) ($_GET['page'] ?? 1));
        $limit = max(1, (int) ($_GET['limit'] ?? 50));

        $result = $this->categoryService->paginate($page, $limit);

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
     * GET /api/categories/{id}
     */
    public function show(int $id): void
    {
        $category = $this->categoryService->getById($id);
        if (!$category) {
            ApiResponse::error('Category not found.', 404);
        }

        ApiResponse::success(ApiResponse::dto($category));
    }

    /**
     * POST /api/categories
     * Body: { name, slug? }
     */
    public function store(): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();

        try {
            $id = $this->categoryService->create($data);
            $category = $this->categoryService->getById($id);

            ApiResponse::success(
                $category ? ApiResponse::dto($category) : ['id' => $id],
                'Category created successfully.',
                201
            );
        } catch (\InvalidArgumentException $e) {
            ApiResponse::error($e->getMessage(), 422);
        } catch (\RuntimeException $e) {
            ApiResponse::error($e->getMessage(), 409);
        }
    }

    /**
     * PUT /api/categories/{id}
     * Body: { name?, slug? }
     */
    public function update(int $id): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();
        $this->categoryService->update($id, $data);

        $category = $this->categoryService->getById($id);
        if (!$category) {
            ApiResponse::error('Category not found.', 404);
        }

        ApiResponse::success(ApiResponse::dto($category), 'Category updated successfully.');
    }

    /**
     * DELETE /api/categories/{id}
     */
    public function destroy(int $id): void
    {
        Auth::requireAdmin();

        $affected = $this->categoryService->delete($id);
        if ($affected === 0) {
            ApiResponse::error('Category not found.', 404);
        }

        ApiResponse::success(null, 'Category deleted successfully.');
    }
}
