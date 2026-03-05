<?php
require_once __DIR__ . '/BaseDAO.php';

class UserDAO extends BaseDAO
{
    protected string $table      = 'users';
    protected string $primaryKey = 'id';

    /**
     * Find a user by email address.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->findOneWhere(['email' => $email]);
    }

    /**
     * Search users by name or email with pagination.
     */
    public function search(string $keyword, int $page = 1, int $limit = 20): array
    {
        $like   = "%{$keyword}%";
        $offset = ($page - 1) * $limit;

        $countStmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE full_name LIKE :kw OR email LIKE :kw2"
        );
        $countStmt->execute([':kw' => $like, ':kw2' => $like]);
        $total = (int) $countStmt->fetchColumn();

        $dataStmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table}
             WHERE full_name LIKE :kw OR email LIKE :kw2
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
     * Register a new user (hashes the plain-text password).
     * Returns the new user ID.
     */
    public function register(string $email, string $password, string $fullName = '', string $phone = ''): int
    {
        return $this->insert([
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'full_name'     => $fullName,
            'phone'         => $phone,
        ]);
    }
}