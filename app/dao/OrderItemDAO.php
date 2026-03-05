<?php
require_once __DIR__ . '/BaseDAO.php';

class OrderItemDAO extends BaseDAO
{
    protected string $table      = 'order_items';
    protected string $primaryKey = 'id';

    /**
     * Get all items for an order.
     */
    public function findByOrder(int $orderId): array
    {
        return $this->findWhere(['order_id' => $orderId]);
    }

    /**
     * Get all order-item rows for a specific product (sales history).
     */
    public function findByProduct(int $productId): array
    {
        return $this->findWhere(['product_id' => $productId], 'id', 'DESC');
    }

    /**
     * Bulk-insert order items from a cart snapshot.
     * $items = [['product_id' => …, 'quantity' => …, 'unit_price' => …], …]
     */
    public function insertMany(int $orderId, array $items): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} (order_id, product_id, quantity, unit_price)
             VALUES (:oid, :pid, :qty, :price)"
        );
        foreach ($items as $item) {
            $stmt->execute([
                ':oid'   => $orderId,
                ':pid'   => $item['product_id'],
                ':qty'   => $item['quantity'],
                ':price' => $item['unit_price'],
            ]);
        }
    }
}
