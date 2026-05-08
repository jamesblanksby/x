<?php

namespace Platform\Domain\Service;

use Platform\Domain\Repository\PageRepository;

class PageService extends EntityService
{
    public function __construct(PageRepository $pageRepository)
    {
        parent::__construct($pageRepository);
    }

    public function get($value, string $property = 'uid', array $context = []): array
    {
        $page = parent::get($value, $property, $context);

        // @TODO block and content

        return $page;
    }

    public function select(string $type): array
    {
        $rows = $this->repository->many([
            'type' => $type,
        ]);

        return array_map([$this, 'hydrate'], $rows);
    }

    public function hydrate(array $image): array
    {
        // @TODO images
        // @TODO url

        return parent::hydrate($image);
    }
}
