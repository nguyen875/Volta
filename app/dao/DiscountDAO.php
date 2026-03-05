<?php
require_once __DIR__ . '/BaseDAO.php';

class DiscountDAO extends BaseDAO
{
    protected string $table      = 'discounts';
    protected string $primaryKey = 'id';

    /**
     * Find a discount by its promo code.
     */
    public function findByCode(string $code): ?array
    {
        return $this->findOneWhere(['code' => $code]);
    }

    /**
     * Get all currently valid discounts (not expired, uses remaining > 0 or unlimited).
     */
    public function findValid(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table}
             WHERE (expires_at IS NULL OR expires_at > NOW())
               AND (uses_remaining IS NULL OR uses_remaining > 0)
             ORDER BY id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Decrement uses_remaining by 1 (for codes with a usage cap).
     * Returns number of affected rows.
     */
    public function decrementUse(int $id): int
    {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->table}
             SET uses_remaining = uses_remaining - 1
             WHERE id = :id AND uses_remaining > 0"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }
}
