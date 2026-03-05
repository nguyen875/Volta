<?php
// app/controllers/UserController.php

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/UserService.php';

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * GET /api/users?search=&page=&limit=
     */
    public function index(): void
    {
        Auth::requireAdmin();

        $search = $_GET['search'] ?? '';
        $page   = max(1, (int) ($_GET['page'] ?? 1));
        $limit  = in_array((int) ($_GET['limit'] ?? 20), [10, 20, 25, 50]) ? (int) $_GET['limit'] : 20;

        if ($search !== '') {
            $result = $this->userService->search($search, $page, $limit);
        } else {
            $result = $this->userService->paginate($page, $limit);
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
     * GET /api/users/{id}
     */
    public function show(int $id): void
    {
        Auth::requireAdmin();

        $user = $this->userService->getById($id);
        if (!$user) {
            ApiResponse::error('User not found.', 404);
        }

        ApiResponse::success(ApiResponse::dto($user));
    }

    /**
     * POST /api/users
     * Body: { email, password, full_name, phone }
     */
    public function store(): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();

        try {
            $id = $this->userService->create($data);
            $user = $this->userService->getById($id);

            ApiResponse::success(
                $user ? ApiResponse::dto($user) : ['id' => $id],
                'User created successfully.',
                201
            );
        } catch (\InvalidArgumentException $e) {
            ApiResponse::error($e->getMessage(), 422);
        } catch (\RuntimeException $e) {
            ApiResponse::error($e->getMessage(), 409);
        }
    }

    /**
     * PUT /api/users/{id}
     * Body: { email?, full_name?, phone?, password? }
     */
    public function update(int $id): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();
        $affected = $this->userService->update($id, $data);

        $user = $this->userService->getById($id);
        if (!$user) {
            ApiResponse::error('User not found.', 404);
        }

        ApiResponse::success(ApiResponse::dto($user), 'User updated successfully.');
    }

    /**
     * DELETE /api/users/{id}
     */
    public function destroy(int $id): void
    {
        Auth::requireAdmin();

        $affected = $this->userService->delete($id);
        if ($affected === 0) {
            ApiResponse::error('User not found.', 404);
        }

        ApiResponse::success(null, 'User deleted successfully.');
    }
}
