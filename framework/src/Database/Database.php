<?php

namespace Framework\Database;

class Database
{
    /** @var ?Connection */
    private $connection = null;
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function connection(): Connection
    {
        if ($this->connection === null) {
            $this->connection = Connection::create($this->config);
        }

        return $this->connection;
    }

    public function execute(string $sql, array $params = []): \PDOStatement
    {
        return $this->connection()->execute($sql, $params);
    }

    public function insertId(): ?int
    {
        return (int) $this->connection()->insertId();
    }
}
