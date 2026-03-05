<?php
// app/controllers/CartController.php
// Admin order management

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/CartService.php';

class CartController
{
    private CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    /**
     * GET /api/orders?page=&limit=&status=
     */
    public function index(): void
    {
        Auth::requireAdmin();

        $page   = max(1, (int) ($_GET['page'] ?? 1));
        $limit  = max(1, (int) ($_GET['limit'] ?? 20));
        $status = $_GET['status'] ?? null;

        $conditions = [];
        if ($status) {
            $conditions['status'] = $status;
        }

        $result = $this->cartService->paginate($page, $limit, $conditions);

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
     * GET /api/orders/{id}
     */
    public function show(int $id): void
    {
        Auth::requireAdmin();

        $data = $this->cartService->getWithItems($id);
        if (!$data) {
            ApiResponse::error('Order not found.', 404);
        }

        ApiResponse::success([
            'order' => ApiResponse::dto($data['order']),
            'items' => ApiResponse::dtoList($data['items']),
        ]);
    }

    /**
     * PUT /api/orders/{id}
     * Body: { status?, address_id?, total_price? }
     */
    public function update(int $id): void
    {
        Auth::requireAdmin();

        $data = ApiResponse::body();

        try {
            // If only status, use the dedicated method with validation
            if (isset($data['status']) && count($data) === 1) {
                $this->cartService->updateStatus($id, $data['status']);
            } else {
                $this->cartService->update($id, $data);
            }

            $order = $this->cartService->getById($id);
            if (!$order) {
                ApiResponse::error('Order not found.', 404);
            }

            ApiResponse::success(ApiResponse::dto($order), 'Order updated successfully.');

        } catch (\InvalidArgumentException $e) {
            ApiResponse::error($e->getMessage(), 422);
        }
    }

    /**
     * GET /api/orders/stats?start_date=&end_date=
     */
    public function stats(): void
    {
        Auth::requireAdmin();

        $startDate = $_GET['start_date'] ?? null;
        $endDate   = $_GET['end_date'] ?? null;

        $stats = $this->cartService->getStats($startDate, $endDate);
        ApiResponse::success($stats);
    }
}
