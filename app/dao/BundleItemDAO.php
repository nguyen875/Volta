<?php
require_once __DIR__ . '/BaseDAO.php';

class BundleItemDAO extends BaseDAO
{
    protected string $table      = 'bundle_items';
    protected string $primaryKey = 'id';

    /**
     * Get all items belonging to a bundle.
     */
    public function findByBundle(int $bundleId): array
    {
        return $this->findWhere(['bundle_id' => $bundleId]);
    }

    /**
     * Find all bundles that contain a specific product.
     */
    public function findByProduct(int $productId): array
    {
        return $this->findWhere(['product_id' => $productId]);
    }

    /**
     * Remove all items from a bundle.
     */
    public function deleteByBundle(int $bundleId): int
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE bundle_id = :bid");
        $stmt->execute([':bid' => $bundleId]);
        return $stmt->rowCount();
    }
}
