<?php

namespace Platform\Domain\Service;

use Framework\Http\Request\Request;
use Platform\Domain\Repository\PageRepository;

class PageService extends EntityService
{
    /** @var Request */
    private $request;

    public function __construct(
        PageRepository $pageRepository,
        Request $request
    ) {
        parent::__construct($pageRepository);

        $this->request = $request;
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

    public function hydrate(array $page): array
    {
        // @TODO images
        $page['url'] = $this->url($page);

        return parent::hydrate($page);
    }

    private function url(array $page): string
    {
        if ($page['slug'] === 'index') {
            return $this->request->getUrl();
        }

        return $this->request->getUrlForPath($page['slug']);
    }
}
