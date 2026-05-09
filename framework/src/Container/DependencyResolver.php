<?php

namespace Framework\Container;

class DependencyResolver
{
    /** @var DependencyBuilder */
    private $builder;
    /** @var ContainerRegistry */
    private $registry;

    public function __construct(
        DependencyBuilder $builder,
        ContainerRegistry $registry
    ) {
        $this->builder = $builder;
        $this->registry = $registry;
    }

    /** @return mixed */
    public function resolve(string $id, array $params, callable $make)
    {
        if ($this->registry->hasDefinition($id)) {
            return $this->resolveDefinition($id, $params, $make);
        }

        if (class_exists($id)) {
            return $this->builder->build($id, $params, $make);
        }

        throw new \RuntimeException("Unable to resolve `{$id}`.");
    }

    /** @return mixed */
    private function resolveDefinition(string $id, array $params, callable $make)
    {
        $definition = $this->registry->getDefinition($id);

        if (is_callable($definition)) {
            return $definition($make, $params);
        }

        if (is_string($definition) && class_exists($definition)) {
            return $this->builder->build($definition, $params, $make);
        }

        return $definition;
    }
}
