<?php
require_once __DIR__ . '/BaseDAO.php';

class ProductImageDAO extends BaseDAO
{
    protected string $table      = 'product_images';
    protected string $primaryKey = 'id';

    /**
     * Get all images for a product (primary image first).
     */
    public function findByProduct(int $productId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE product_id = :pid ORDER BY is_primary DESC, id ASC"
        );
        $stmt->execute([':pid' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get only the primary image for a product.
     */
    public function findPrimary(int $productId): ?array
    {
        return $this->findOneWhere(['product_id' => $productId, 'is_primary' => 1]);
    }

    /**
     * Set an image as primary, un-primary the rest for the same product.
     */
    public function setPrimary(int $productId, int $imageId): void
    {
        $this->pdo->prepare("UPDATE {$this->table} SET is_primary = 0 WHERE product_id = :pid")
                   ->execute([':pid' => $productId]);
        $this->update($imageId, ['is_primary' => 1]);
    }

    /**
     * Delete all images for a product.
     */
    public function deleteByProduct(int $productId): int
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE product_id = :pid");
        $stmt->execute([':pid' => $productId]);
        return $stmt->rowCount();
    }
}
