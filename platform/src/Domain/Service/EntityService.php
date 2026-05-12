<?php

namespace Platform\Domain\Service;

use Framework\Http\Exception\NotFoundException;
use Framework\Repository\Repository;

abstract class EntityService
{
    /** @var Repository */
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function insert(array $input): array
    {
        $data = $this->normalize($input);

        $instance = $this->repository->insert($data);

        return $this->find($instance['id']);
    }

    /** @param mixed $value */
    public function find($value, string $property = 'id'): ?array
    {
        if (!$value) {
            return null;
        }

        $row = $this->repository->first([
            $property => $value,
        ]);

        return $row ? $this->hydrate($row) : null;
    }

    /** @param mixed $value */
    public function get($value, string $property = 'id', array $context = []): array
    {
        $wheres = $this->applyContext([
            $property => $value,
        ], $context);

        $row = $this->repository->first($wheres);

        if ($row === null) {
            throw new NotFoundException();
        }

        return $row ? $this->hydrate($row) : null;
    }

    public function all(): array
    {
        $rows = $this->repository->all();

        return array_map([$this, 'hydrate'], $rows);
    }

    public function hydrate(array $instance): array
    {
        return $this->sortProperties($instance);
    }

    public function update(array $instance, array $input): array
    {
        $data = $this->normalize($input, $instance);

        $this->repository->update($instance['id'], $data);

        return $this->find($instance['id']);
    }

    public function delete(array $instance): void
    {
        // @TODO block, content, page and image

        $this->repository->delete($instance['id']);
    }

    protected function normalize(array $data, ?array $instance = null): array
    {
        return $data;
    }

    protected function applyContext(array $where, array $context = []): array
    {
        $display = $context['display'] ?? null;

        if ($display !== null) {
            $where['display'] = (bool) $display;
        }

        return $where;
    }

    private function sortProperties(array $instance): array
    {
        ksort($instance);

        foreach ($instance as $key => $value) {
            if (is_array($value)) {
                $instance[$key] = $this->sortProperties($value);
            }
        }

        return $instance;
    }
}
