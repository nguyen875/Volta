<?php
require_once __DIR__ . '/BaseDAO.php';

class ProductDAO extends BaseDAO
{
    protected string $table      = 'products';
    protected string $primaryKey = 'id';

    /**
     * Search products by name/description with pagination.
     */
    public function search(string $keyword, int $page = 1, int $limit = 20): array
    {
        $like   = "%{$keyword}%";
        $offset = ($page - 1) * $limit;

        $countStmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE is_active = 1 AND (name LIKE :kw OR description LIKE :kw2)"
        );
        $countStmt->execute([':kw' => $like, ':kw2' => $like]);
        $total = (int) $countStmt->fetchColumn();

        $dataStmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table}
             WHERE is_active = 1 AND (name LIKE :kw OR description LIKE :kw2)
             ORDER BY created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $dataStmt->bindValue(':kw',     $like);
        $dataStmt->bindValue(':kw2',    $like);
        $dataStmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();

        return [
            'data'  => $dataStmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page'  => $page,
            'limit' => $limit,
        ];
    }

    /**
     * Find active products by category ID.
     */
    public function findByCategory(int $categoryId, string $orderBy = 'created_at', string $dir = 'DESC'): array
    {
        return $this->findWhere(['category_id' => $categoryId, 'is_active' => 1], $orderBy, $dir);
    }

    /**
     * Find a product by its URL slug.
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->findOneWhere(['slug' => $slug]);
    }

    /**
     * Find products with a specific badge (new, hot, sale).
     */
    public function findByBadge(string $badge, int $limit = 10): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE is_active = 1 AND badge = :badge ORDER BY created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':badge', $badge);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Set primary image
     */
    public function setPrimaryImage($productId, $imageId) {
        // Placeholder - can be implemented with is_primary column
        return true;
    }
}
