<?php

namespace Framework\Http\Request;

use Framework\Container\Container;
use Framework\Http\Exception\HttpException;

class ParameterResolver
{
    /** @var Container */
    private $container;
    /** @var RequestContext */
    private $requestContext;

    public function __construct(
        Container $container,
        RequestContext $requestContext
    ) {
        $this->container = $container;
        $this->requestContext = $requestContext;
    }

    public function resolveMethodArgs(\ReflectionMethod $method, Request $request): array
    {
        $args = [];
        foreach ($method->getParameters() as $parameter) {
            $args[] = $this->resolveParameter($parameter, $request);
        }

        return $args;
    }

    /** @return mixed */
    private function resolveParameter(\ReflectionParameter $parameter, Request $request)
    {
        $type = $parameter->getType();
        $name = $parameter->getName();

        if ($type instanceof \ReflectionNamedType && $this->isRequestType($type->getName())) {
            return $request;
        }

        $params = $this->requestContext->getRouteMatch()->getParams();
        $attribute = $params[$name] ?? null;

        if ($attribute !== null) {
            return $this->castAttribute($attribute, $type);
        }

        if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
            return $this->container->get($type->getName());
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if ($type === null || $type->allowsNull()) {
            return null;
        }

        $class = $parameter->getDeclaringClass();
        $function = $parameter->getDeclaringFunction();

        throw new HttpException(500, "Cannot resolve parameter `\${$name}` on `{$class->getName()}::{$function->getName()}`.");
    }

    private function isRequestType(string $typeName): bool
    {
        return $typeName === Request::class || is_a($typeName, Request::class, true);
    }

    /**
     * @param mixed $value
     * @return mixed
     * */
    private function castAttribute($value, ?\ReflectionType $type)
    {
        if (!$type instanceof \ReflectionNamedType || !$type->isBuiltin()) {
            return $value;
        }

        switch ($type->getName()) {
            case 'int':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'bool':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        return $value;
    }
}
