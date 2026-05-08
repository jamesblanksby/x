<?php

namespace Framework\Repository;

use Framework\Database\Database;
use Framework\Database\Query;

abstract class Repository
{
    /** @var Database */
    protected $database;
    /** @var string */
    protected $table;

    /** @var SchemaInspector */
    private $schema;
    /** @var RowMapper */
    private $mapper;

    public function __construct(
        Database $database,
        string $table
    ) {
        $this->database = $database;
        $this->table = $table;

        $this->schema = new SchemaInspector($this->database, $this->table);
        $this->mapper = new RowMapper($this->schema);
    }

    public function insert(array $input): array
    {
        $data = $this->normalize($input);

        $query = $this->query()
            ->insert($this->table)
            ->data($data)
        ;

        $id = $query->execute()->insertId();

        return $this->find($id);
    }

    public function find(int $id): ?array
    {
        return $this->first(['id' => $id]);
    }

    /** @param array|string|null $orders */
    public function first(array $wheres, $orders = null): ?array
    {
        $rows = $this->many($wheres, $orders, 1);

        if (!$rows) {
            return null;
        }

        return $rows[0];
    }

    /** @param array|string|null $orders */
    public function many(array $wheres, $orders = null, ?int $limit = null, ?int $offset = null): array
    {
        $query = $this->query()
            ->select()
            ->from($this->table)
        ;

        if ($wheres) {
            $query->where($wheres);
        }

        if ($orders !== null) {
            $query->orderby($orders);
        }

        if ($limit !== null) {
            $query->limit($limit);
        }

        if ($offset !== null) {
            $query->offset($offset);
        }

        $rows = $query->execute()->fetchAll();

        return array_map([$this, 'hydrate'], $rows);
    }

    public function all(): array
    {
        return $this->many([]);
    }

    public function hydrate(array $row): array
    {
        return $this->mapper->hydrate($row);
    }

    public function update(int $id, array $input): array
    {
        $data = $this->normalize($input, $id);

        $this->query()
            ->update($this->table)
            ->data($data)
            ->where(['id' => $id])
            ->execute()
        ;

        return $this->find($id);
    }

    public function patch(int $id, array $data): array
    {
        $this->query()
            ->update($this->table)
            ->data($data)
            ->where(['id' => $id])
            ->execute()
        ;

        return $this->find($id);
    }

    public function delete(int $id): int
    {
        $query = $this->query()
            ->delete($this->table)
            ->where(['id' => $id])
        ;

        return $query->execute()->rowCount();
    }

    public function query(): Query
    {
        return new Query($this->database);
    }

    protected function normalize(array $data, ?int $id = null): array
    {
        return $this->mapper->normalize($data);
    }
}
