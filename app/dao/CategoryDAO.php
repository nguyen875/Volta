<?php
require_once __DIR__ . '/BaseDAO.php';

class CategoryDAO extends BaseDAO
{
    protected string $table      = 'categories';
    protected string $primaryKey = 'id';

    /**
     * Find a category by its URL slug.
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->findOneWhere(['slug' => $slug]);
    }
}
