<?php

namespace Platform\Form\Type;

interface ContainerTypeInterface extends TypeInterface
{
    /** @return static */
    public function setChildren(array $children);

    public function getChildren(): array;
}
