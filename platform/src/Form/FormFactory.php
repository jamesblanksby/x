<?php

namespace Platform\Form;

use Framework\Http\Request\RequestContext;

class FormFactory
{
    /** @var FormRegistry */
    private $registry;
    /** @var RequestContext */
    private $requestContext;

    public function __construct(
        FormRegistry $registry,
        RequestContext $requestContext
    ) {
        $this->registry = $registry;
        $this->requestContext = $requestContext;
    }

    public function create(string $typeClass, array $options = []): Form
    {
        $type = $this->registry->resolve($typeClass);
        $options = array_merge($type->setDefaults(), $options);

        $builder = new FormBuilder($this->registry);
        $type->build($builder);

        if ($options['action'] === null) {
            $options['action'] = $this->requestContext->getRequest()->getUrl();
        }

        $form = new Form($type, $options);

        foreach ($builder->getChildren() as $child) {
            $form->addChild($child);
        }

        return $form;
    }
}
