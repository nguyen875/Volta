<?php
require_once __DIR__ . '/BaseDAO.php';

class OrderDAO extends BaseDAO
{
    protected string $table      = 'orders';
    protected string $primaryKey = 'id';

    /**
     * Get orders for a user (newest first).
     */
    public function findByUser(int $userId): array
    {
        return $this->findWhere(['user_id' => $userId], 'created_at', 'DESC');
    }

    /**
     * Get orders filtered by status.
     */
    public function findByStatus(string $status): array
    {
        return $this->findWhere(['status' => $status], 'created_at', 'DESC');
    }

    /**
     * Update only the status of an order.
     */
    public function updateStatus(int $orderId, string $status): int
    {
        return $this->update($orderId, ['status' => $status]);
    }

    /**
     * Get an order with its items and product details.
     */
    public function findWithItems(int $orderId): ?array
    {
        $order = $this->findById($orderId);
        if (!$order) return null;

        $stmt = $this->pdo->prepare(
            "SELECT oi.*, p.name, p.slug,
                    (SELECT pi.url FROM product_images pi WHERE pi.product_id = p.id AND pi.is_primary = 1 LIMIT 1) AS image_url
             FROM order_items oi
             JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id = :oid
             ORDER BY oi.id ASC"
        );
        $stmt->execute([':oid' => $orderId]);
        $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $order;
    }

    /**
     * Revenue / order stats with optional date filtering.
     */
    public function getStats(?string $startDate = null, ?string $endDate = null): array
    {
        $where  = '';
        $params = [];
        $conditions = [];

        if ($startDate) {
            $conditions[]          = "created_at >= :start";
            $params[':start']      = $startDate;
        }
        if ($endDate) {
            $conditions[]          = "created_at <= :end";
            $params[':end']        = $endDate;
        }
        if ($conditions) {
            $where = 'WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->pdo->prepare(
            "SELECT
                 COUNT(*)                                                        AS total_orders,
                 COALESCE(SUM(total_price), 0)                                   AS total_revenue,
                 SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END)           AS completed_orders,
                 SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END)          AS cancelled_orders
             FROM {$this->table} {$where}"
        );
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
