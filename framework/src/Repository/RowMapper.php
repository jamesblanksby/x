<?php

namespace Framework\Repository;

class RowMapper
{
    /** @var SchemaInspector */
    private $schema;

    public function __construct(SchemaInspector $schema)
    {
        $this->schema = $schema;
    }

    public function hydrate(array $row): array
    {
        $types = $this->schema->getColumnTypes();

        foreach ($row as $key => $value) {
            if (!isset($types[$key])) {
                continue;
            }

            $row[$key] = $this->castToPhp($value, $types[$key]);
        }

        return $row;
    }

    public function normalize(array $row): array
    {
        $types = $this->schema->getColumnTypes();

        foreach ($row as $key => $value) {
            if (!isset($types[$key])) {
                continue;
            }

            $row[$key] = $this->castToDatabase($value, $types[$key]);
        }

        return $row;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function castToPhp($value, string $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case 'int':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'bool':
                return (bool) $value;
            case 'json':
                $json = json_decode((string) $value, true);
                return json_last_error() === JSON_ERROR_NONE ? $json : null;
            case 'datetime':
                return new \DateTimeImmutable((string) $value);
        }

        return (string) $value;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function castToDatabase($value, string $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case 'json':
                return json_encode($value);
            case 'datetime':
                if ($value instanceof \DateTimeInterface) {
                    return $value->format('Y-m-d H:i:s');
                }
                return $value ? (string) $value : null;
            case 'bool':
                return $value ? 1 : 0;
        }

        return $value;
    }
}
