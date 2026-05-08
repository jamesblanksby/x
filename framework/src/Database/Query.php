<?php

namespace Framework\Database;

class Query
{
    /** @var Database */
    private $database;
    /** @var string */
    private $type = 'select';
    /** @var string */
    private $table = '';
    /** @var array */
    private $selects = ['*'];
    /** @var array */
    private $wheres = [];
    /** @var array */
    private $joins = [];
    /** @var array */
    private $groupbys = [];
    /** @var array */
    private $orderbys = [];
    /** @var ?int */
    private $limit = null;
    /** @var ?int */
    private $offset = null;
    /** @var array */
    private $data = [];
    /** @var array */
    private $params = [];
    /** @var int */
    private $index = 0;
    /** @var array */
    private $before = [];
    /** @var array */
    private $after = [];

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function table(): string
    {
        return $this->table;
    }

    /** @param array|string $columns */
    public function select($columns = ['*']): self
    {
        $this->reset();
        $this->type = 'select';
        $this->selects = (array) $columns;

        return $this;
    }

    public function count(string $column = '*'): self
    {
        $this->reset();
        $this->type = 'count';
        $this->selects = ["COUNT({$column})"];

        return $this;
    }

    public function insert(string $table): self
    {
        $this->reset();
        $this->type = 'insert';
        $this->table = $table;

        return $this;
    }

    public function update(string $table): self
    {
        $this->reset();
        $this->type = 'update';
        $this->table = $table;

        return $this;
    }

    public function delete(string $table): self
    {
        $this->reset();
        $this->type = 'delete';
        $this->table = $table;

        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function data(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public function where(array $wheres): self
    {
        foreach ($wheres as $key => $value) {
            $this->parseWhere($key, $value);
        }

        return $this;
    }

    public function join(string $table, string $on, string $type = 'INNER'): self
    {
        $this->joins[] = [
            'type' => $type,
            'table' => $table,
            'on' => $on,
        ];

        return $this;
    }

    /** @param array|string $columns */
    public function groupby($columns): self
    {
        $this->groupbys = array_merge($this->groupbys, (array) $columns);
        return $this;
    }

    /** @param array|string $orders */
    public function orderby($orders): self
    {
        foreach ((array) $orders as $key => $value) {
            $this->parseOrderby($key, $value);
        }

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function before(callable $fn): self
    {
        $this->before[] = $fn;
        return $this;
    }

    public function after(callable $fn): self
    {
        $this->after[] = $fn;
        return $this;
    }

    public function build(): array
    {
        $this->params = [];
        $this->index = 0;

        switch ($this->type) {
            case 'insert':
                $sql = $this->insertQuery();
                break;
            case 'update':
                $sql = $this->updateQuery();
                break;
            case 'delete':
                $sql = $this->deleteQuery();
                break;
            default:
                $sql = $this->selectQuery();
        }

        return [$sql, $this->params];
    }

    public function execute(): Result
    {
        $this->runHooks($this->before, $this);

        list($sql, $params) = $this->build();
        $stmt = $this->database->execute($sql, $params);

        $this->runHooks($this->after, $this, $stmt);

        return new Result(
            $this->type,
            $stmt,
            $this->database->insertId()
        );
    }

    public function reset(): void
    {
        $this->type = 'select';
        $this->table = '';
        $this->selects = ['*'];
        $this->wheres = [];
        $this->joins = [];
        $this->groupbys = [];
        $this->orderbys = [];
        $this->limit = null;
        $this->offset = null;
        $this->data = [];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    private function parseWhere($key, $value): void
    {
        if (is_int($key) && is_string($value)) {
            $this->wheres[] = [
                'logic' => $value
            ];

            return;
        }

        list($column, $operator, $value) = $this->extractWhere($key, $value);

        $this->wheres[] = [
            'operator' => $operator,
            'column' => $column,
            'value' => $value,
        ];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    private function extractWhere($key, $value): array
    {
        if (is_int($key) && is_array($value)) {
            if (isset($value[2])) {
                return $value;
            }

            $column = array_key_first($value);

            return [$column, '=', $value[$column]];
        }

        return [$key, '=', $value];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    private function parseOrderby($key, $value): void
    {
        if (is_int($key)) {
            if (strpos($value, 'RAND') === 0) {
                $this->orderbys[] = $value;
            } else {
                $this->orderbys[] = [$value => 'ASC'];
            }
        } else {
            $this->orderbys[] = [$key => $value];
        }
    }

    private function selectQuery(): string
    {
        $sql = 'SELECT';

        if ($this->selects) {
            $sql .= $this->buildSelect();
        }

        $sql .= " FROM `{$this->table}`";

        if ($this->joins) {
            $sql .= $this->buildJoin();
        }

        if ($this->wheres) {
            $sql .= $this->buildWhere();
        }

        if ($this->groupbys) {
            $sql .= $this->buildGroupby();
        }

        if ($this->orderbys) {
            $sql .= $this->buildOrderby();
        }

        if ($this->limit) {
            $sql .= $this->buildLimit();
        }

        if ($this->offset) {
            $sql .= $this->buildOffset();
        }

        return $sql;
    }

    private function insertQuery(): string
    {
        $sql = "INSERT INTO `{$this->table}`";

        if ($this->data) {
            $sql .= $this->buildSet();
        }

        return $sql;
    }

    private function updateQuery(): string
    {
        $sql = "UPDATE `{$this->table}`";

        if ($this->data) {
            $sql .= $this->buildSet();
        }

        if ($this->joins) {
            $sql .= $this->buildJoin();
        }

        if ($this->wheres) {
            $sql .= $this->buildWhere();
        }

        return $sql;
    }

    private function deleteQuery(): string
    {
        $sql = "DELETE FROM `{$this->table}`";

        if ($this->joins) {
            $sql .= $this->buildJoin();
        }

        if ($this->wheres) {
            $sql .= $this->buildWhere();
        }

        return $sql;
    }

    private function buildSelect(): string
    {
        $selects = array_map(function ($select) {
            if (strpos($select, '(') !== false) {
                return $select;
            }

            return $this->quote($select);
        }, $this->selects);

        return ' ' . implode(', ', $selects);
    }

    private function buildJoin(): string
    {
        $joins = array_map(function ($join) {
            $on = $this->quoteJoin($join['on']);

            return "{$join['type']} JOIN `{$join['table']}` ON {$on}";
        }, $this->joins);

        return ' ' . implode(' ', $joins);
    }

    private function buildSet(): string
    {
        $sets = [];

        foreach ($this->data as $column => $value) {
            $param = $this->bindParam($column, $value);
            $column = $this->quote($column);
            $sets[] = "{$column} = {$param}";
        }

        return ' SET ' . implode(', ', $sets);
    }

    private function buildWhere(): string
    {
        $groups = [];
        $wheres = [];

        $logic = 'AND';

        foreach ($this->wheres as $where) {
            if (isset($where['logic'])) {
                if ($wheres) {
                    $groups[] = [
                        'logic' => $logic,
                        'wheres' => $wheres,
                    ];
                    $wheres = [];
                }

                $logic = $where['logic'];
                continue;
            }

            $wheres[] = $this->buildCondition($where);
        }

        if ($wheres) {
            $groups[] = [
                'logic' => $logic,
                'wheres' => $wheres,
            ];
        }

        return ' WHERE ' . $this->buildClause($groups);
    }

    private function buildCondition(array $where): string
    {
        $column = $this->quote($where['column']);
        list($operator, $value) = $this->normalizeCondition($where);

        return "{$column} {$operator} {$value}";
    }

    private function normalizeCondition(array $where): array
    {
        $operator = $where['operator'];
        $value = $where['value'];
        $column = $where['column'];

        if ($value === null) {
            $operator = $operator === '=' ? 'IS' : 'IS NOT';
            return [$operator, 'NULL'];
        }

        if (in_array($operator, ['IN', 'NOT IN'])) {
            $placeholders = array_map(function ($value) use ($column) {
                return $this->bindParam($column, $value);
            }, (array) $value);

            $value = '(' . implode(', ', $placeholders) . ')';

            return [$operator, $value];
        }

        return [$operator, $this->bindParam($column, $value)];
    }

    private function buildClause(array $groups): string
    {
        $sql = '';

        foreach ($groups as $group) {
            $clause = '(' . implode(' AND ', $group['wheres']) . ')';

            if ($sql === '') {
                $sql = $clause;
                continue;
            }

            $sql .= " {$group['logic']} {$clause}";
        }

        return $sql;
    }

    private function buildGroupby(): string
    {
        $columns = array_map(function ($col) {
            return $this->quote($col);
        }, $this->groupbys);

        return ' GROUP BY ' . implode(', ', $columns);
    }

    private function buildOrderby(): string
    {
        $orderbys = [];

        foreach ($this->orderbys as $orderby) {
            if (is_string($orderby)) {
                $orderbys[] = $orderby;
                continue;
            }

            foreach ($orderby as $column => $direction) {
                $prefix = (substr($column, 0, 1) === '-') ? '-' : '';
                $column = $this->quote(ltrim($column, '-'));
                $orderbys[] = "{$prefix}{$column} {$direction}";
            }
        }

        return ' ORDER BY ' . implode(', ', $orderbys);
    }

    private function buildLimit(): string
    {
        return " LIMIT {$this->limit}";
    }

    private function buildOffset(): string
    {
        return " OFFSET {$this->offset}";
    }

    /** @param mixed $value */
    private function bindParam(string $column, $value): string
    {
        $key = str_replace('.', '_', $column);
        $param = "{$key}_{$this->index}";

        $this->params[$param] = $value;
        $this->index++;

        return ":{$param}";
    }

    private function quote(string $identifier): string
    {
        $parts = explode('.', $identifier);

        $parts = array_map(function ($part) {
            if ($part === '*') {
                return '*';
            }
            return "`{$part}`";
        }, $parts);

        return implode('.', $parts);
    }

    private function quoteJoin(string $condition): string
    {
        return preg_replace_callback('/([a-z_]+)\.([a-z_]+)/i', function ($matches) {
            return $this->quote($matches[0]);
        }, $condition);
    }

    /** @param mixed $args */
    private function runHooks(array $hooks, ...$args): void
    {
        foreach ($hooks as $fn) {
            $fn(...$args);
        }
    }
}
