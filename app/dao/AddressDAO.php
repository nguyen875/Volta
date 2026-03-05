<?php
require_once __DIR__ . '/BaseDAO.php';

class AddressDAO extends BaseDAO
{
    protected string $table      = 'addresses';
    protected string $primaryKey = 'id';

    /**
     * Get all addresses for a user.
     */
    public function findByUser(int $userId): array
    {
        return $this->findWhere(['user_id' => $userId]);
    }

    /**
     * Get the user's default address.
     */
    public function findDefault(int $userId): ?array
    {
        return $this->findOneWhere(['user_id' => $userId, 'is_default' => 1]);
    }

    /**
     * Set an address as default, un-defaulting others for the same user.
     */
    public function setDefault(int $userId, int $addressId): void
    {
        $this->pdo->prepare("UPDATE {$this->table} SET is_default = 0 WHERE user_id = :uid")
                   ->execute([':uid' => $userId]);
        $this->update($addressId, ['is_default' => 1]);
    }
}
