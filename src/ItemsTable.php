<?php declare(strict_types=1);

namespace TDD;

use PDO;
use phpDocumentor\Reflection\Types\Mixed_;

class ItemsTable
{
    /**
     * @var string
     */
    protected $table = 'items';
    /**
     * @var PDO
     */
    protected $PDO;

    public function __construct(PDO $pdo)
    {
        $this->PDO = $pdo;
    }

    public function __destruct()
    {
        unset($this->PDO);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findForId(int $id)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->table}.id = ?";
        $statement = $this->PDO->prepare($query);
        $statement->execute([$id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
