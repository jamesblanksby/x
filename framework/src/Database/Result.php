<?php

namespace Framework\Database;

class Result
{
    /** @var \PDOStatement */
    private $stmt;
    /** @var string */
    private $type;
    /** @var ?int */
    private $insertId;

    public function __construct(string $type, \PDOStatement $stmt, ?int $insertId = null)
    {
        $this->type = $type;
        $this->stmt = $stmt;
        $this->insertId = $insertId;
    }

    public function fetch(): ?array
    {
        $row = $this->stmt->fetch();

        return $row ?: null;
    }

    public function fetchColumn(): int
    {
        return $this->stmt->fetchColumn();
    }

    public function fetchAll(): array
    {
        return $this->stmt->fetchAll();
    }

    public function insertId(): ?int
    {
        return $this->insertId;
    }

    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    /** @return mixed */
    public function value()
    {
        switch ($this->type) {
            case 'select':
                return $this->fetchAll();
            case 'count':
                return (int) $this->fetchColumn();
            case 'insert':
                return $this->insertId();
            case 'update':
            case 'delete':
                return $this->rowCount();
        }

        return null;
    }
}
