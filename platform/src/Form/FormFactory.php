<?php

namespace Platform\Form;

class FormFactory
{
    public static function create(string $type, array $data = []): Form
    {
        // @TODO set action to current route

        $type = new $type();

        $builder = new FormBuilder($data);
        $type->buildForm($builder);

        return new Form($builder->getFields());
    }
}
