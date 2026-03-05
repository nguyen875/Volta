<?php

/**
 * BaseDAO — Generic CRUD for VOLTA
 * Requires PDO. Extend this class per table.
 *
 * Usage:
 *   class ProductDAO extends BaseDAO {
 *       protected string $table = 'products';
 *       protected string $primaryKey = 'id';
 *   }
 */
abstract class BaseDAO
{
    protected PDO   $pdo;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // ── READ ─────────────────────────────────────────────────

    /**
     * Find one row by primary key.
     * Returns array|null
     */
    public function findById(int $id): ?array
    {
        $sql  = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Find all rows, optional ORDER BY.
     * Returns array of rows.
     */
    public function findAll(string $orderBy = '', string $dir = 'ASC'): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy) {
            $dir = strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY {$orderBy} {$dir}";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find rows matching ALL given conditions (AND).
     *
     * Example:
     *   $dao->findWhere(['is_active' => 1, 'badge' => 'new'])
     */
    public function findWhere(array $conditions, string $orderBy = '', string $dir = 'ASC'): array
    {
        [$where, $params] = $this->buildWhere($conditions);
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        if ($orderBy) {
            $dir = strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY {$orderBy} {$dir}";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find one row matching conditions.
     * Returns array|null
     */
    public function findOneWhere(array $conditions): ?array
    {
        [$where, $params] = $this->buildWhere($conditions);
        $sql  = "SELECT * FROM {$this->table} WHERE {$where} LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Paginate all rows.
     * Returns ['data' => [...], 'total' => int, 'page' => int, 'limit' => int]
     */
    public function paginate(int $page = 1, int $limit = 20, array $conditions = [], string $orderBy = '', string $dir = 'ASC'): array
    {
        $page   = max(1, $page);
        $offset = ($page - 1) * $limit;

        $where  = '';
        $params = [];
        if ($conditions) {
            [$where, $params] = $this->buildWhere($conditions);
            $where = "WHERE {$where}";
        }

        $order = $orderBy ? "ORDER BY {$orderBy} " . (strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC') : '';

        $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} {$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $dataStmt = $this->pdo->prepare("SELECT * FROM {$this->table} {$where} {$order} LIMIT :limit OFFSET :offset");
        foreach ($params as $key => $val) {
            $dataStmt->bindValue($key, $val);
        }
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

    // ── WRITE ────────────────────────────────────────────────

    /**
     * Insert a new row.
     * Returns the new auto-increment ID.
     */
    public function insert(array $data): int
    {
        $columns      = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ":{$k}", array_keys($data)));
        $sql          = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt         = $this->pdo->prepare($sql);
        $stmt->execute($this->prefixKeys($data));
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Update a row by primary key.
     * Returns number of affected rows.
     */
    public function update(int $id, array $data): int
    {
        $set  = implode(', ', array_map(fn($k) => "{$k} = :{$k}", array_keys($data)));
        $sql  = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :__pk";
        $stmt = $this->pdo->prepare($sql);
        $params = $this->prefixKeys($data);
        $params[':__pk'] = $id;
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Delete a row by primary key.
     * Returns number of affected rows.
     */
    public function delete(int $id): int
    {
        $sql  = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    /**
     * Check whether a row exists by primary key.
     */
    public function exists(int $id): bool
    {
        $sql  = "SELECT 1 FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Count all rows, optionally filtered.
     */
    public function count(array $conditions = []): int
    {
        $where  = '';
        $params = [];
        if ($conditions) {
            [$where, $params] = $this->buildWhere($conditions);
            $where = "WHERE {$where}";
        }
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} {$where}");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    // ── TRANSACTION HELPERS ──────────────────────────────────

    public function beginTransaction(): void   { $this->pdo->beginTransaction(); }
    public function commit(): void             { $this->pdo->commit(); }
    public function rollback(): void           { $this->pdo->rollBack(); }

    /**
     * Run a callable inside a transaction.
     * Rolls back automatically on exception.
     *
     * Example:
     *   $dao->transaction(function() use ($dao) {
     *       $dao->insert([...]);
     *       $dao->update(1, [...]);
     *   });
     */
    public function transaction(callable $callback): mixed
    {
        $this->beginTransaction();
        try {
            $result = $callback($this);
            $this->commit();
            return $result;
        } catch (\Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }

    // ── PRIVATE HELPERS ──────────────────────────────────────

    /**
     * Build a WHERE clause string + params array from a conditions map.
     * ['col' => 'val', 'col2' => null]  →  "col = :col AND col2 IS NULL"
     */
    private function buildWhere(array $conditions): array
    {
        $parts  = [];
        $params = [];
        foreach ($conditions as $col => $val) {
            if (is_null($val)) {
                $parts[] = "{$col} IS NULL";
            } else {
                $parts[]           = "{$col} = :w_{$col}";
                $params[":w_{$col}"] = $val;
            }
        }
        return [implode(' AND ', $parts), $params];
    }

    /** Prefix array keys with ':' for PDO named params. */
    private function prefixKeys(array $data): array
    {
        $out = [];
        foreach ($data as $k => $v) {
            $out[":{$k}"] = $v;
        }
        return $out;
    }
}