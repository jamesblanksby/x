<?php

namespace Framework\Repository;

use Framework\Database\Database;

class SchemaInspector
{
    /** @var Database */
    private $database;
    /** @var string */
    private $table;
    /** @var ?array */
    private $columns;

    public function __construct(Database $database, string $table)
    {
        $this->database = $database;
        $this->table = $table;
    }

    public function getColumnTypes(): array
    {
        if ($this->columns !== null) {
            return $this->columns;
        }

        $sql = "
            SELECT COLUMN_NAME, DATA_TYPE, COLUMN_TYPE
            FROM information_schema.columns
            WHERE table_schema = DATABASE()
                AND table_name = '{$this->table}'
        ";

        $rows = $this->database
            ->execute($sql)
            ->fetchAll();

        $types = [];
        foreach ($rows as $row) {
            $types[$row['COLUMN_NAME']] = $this->resolveType(
                strtolower($row['COLUMN_TYPE']),
                strtolower($row['DATA_TYPE'])
            );
        }

        return $this->columns = $types;
    }

    private function resolveType(string $columnType, string $dataType): string
    {
        if ($columnType === 'tinyint(1)') {
            return 'bool';
        }

        if (in_array($dataType, ['int', 'integer', 'bigint', 'mediumint', 'smallint', 'tinyint'])) {
            return 'int';
        }

        if (in_array($dataType, ['decimal', 'float', 'double', 'real', 'numeric'])) {
            return 'float';
        }

        if (in_array($dataType, ['datetime', 'timestamp', 'date', 'time'])) {
            return 'datetime';
        }

        if ($dataType === 'json') {
            return 'json';
        }

        return 'string';
    }
}
