<?php

namespace Framework\Container;

class DependencyBuilder
{
    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    public function build(string $className, array $params, callable $resolver)
    {
        $class = new \ReflectionClass($className);

        if (!$class->isInstantiable()) {
            throw new \RuntimeException("Class `{$class->getName()}` is not instantiable.");
        }

        $args = $this->resolveConstructorArgs($class, $params, $resolver);

        return $class->newInstanceArgs($args);
    }

    /**
     * @template T of object
     * @param \ReflectionClass<T> $class
     */
    public function resolveConstructorArgs(\ReflectionClass $class, array $params, callable $resolver): array
    {
        $constructor = $class->getConstructor();

        if ($constructor === null) {
            return [];
        }

        $args = [];
        foreach ($constructor->getParameters() as $index => $parameter) {
            $args[] = $this->resolveParameter($parameter, $index, $params, $resolver);
        }

        return $args;
    }

    /** @return mixed */
    private function resolveParameter(\ReflectionParameter $parameter, int $index, array $params, callable $resolver)
    {
        $name = $parameter->getName();

        if (array_key_exists($name, $params)) {
            return $params[$name];
        }

        if (array_key_exists($index, $params)) {
            return $params[$index];
        }

        $type = $parameter->getType();

        if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
            return $resolver($type->getName());
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if ($type === null || $type->allowsNull()) {
            return null;
        }

        throw new \RuntimeException("Cannot resolve parameter `\${$name}`.");
    }
}
