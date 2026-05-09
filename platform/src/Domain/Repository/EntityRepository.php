<?php

namespace Platform\Domain\Repository;

use Framework\Database\Database;
use Framework\Repository\Repository;
use Framework\Utility\Uuid;

class EntityRepository extends Repository
{
    /** @var array */
    protected $order;

    public function __construct(Database $database, string $table, ?array $order = null)
    {
        parent::__construct($database, $table);

        $this->order = $order ?? ['id' => 'DESC'];
    }

    public function many(array $wheres, $orders = null, ?int $limit = null, ?int $offset = null): array
    {
        if ($orders === null) {
            $orders = $this->order;
        }

        return parent::many($wheres, $orders, $limit, $offset);
    }

    public function hydrate(array $row): array
    {
        $row['ref'] = $this->table;

        return parent::hydrate($row);
    }

    protected function normalize(array $data, ?int $id = null): array
    {
        if (!$id) {
            $data['uid'] = Uuid::create();
        }

        return parent::normalize($data, $id);
    }
}
