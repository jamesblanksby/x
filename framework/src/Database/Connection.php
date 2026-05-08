<?php

namespace Framework\Database;

class Connection
{
    /** @var \PDO */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function create(Config $config): self
    {
        $pdo = new \PDO(
            $config->dsn(),
            $config->username,
            $config->password
        );

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        return new self($pdo);
    }

    public function execute(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);

        $this->bindParams($stmt, $params);
        $stmt->execute();

        return $stmt;
    }

    public function insertId(): ?int
    {
        $id = $this->pdo->lastInsertId();

        if (!$id) {
            return null;
        }

        return (int) $id;
    }

    private function bindParams(\PDOStatement $stmt, array $params = []): void
    {
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, $this->pdoType($value));
        }
    }

    /** @param mixed $value */
    private function pdoType($value): int
    {
        switch (true) {
            case is_null($value):
                return \PDO::PARAM_NULL;
            case is_bool($value):
                return \PDO::PARAM_BOOL;
            case is_int($value):
                return \PDO::PARAM_INT;
        }

        return \PDO::PARAM_STR;
    }
}
