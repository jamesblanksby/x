<?php

namespace Framework\Database;

class Database
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(string $sql, array $params = []): \PDOStatement
    {
        return $this->connection->execute($sql, $params);
    }

    public function insertId(): ?int
    {
        return (int) $this->connection->insertId();
    }
}
