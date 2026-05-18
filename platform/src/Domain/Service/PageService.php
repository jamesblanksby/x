<?php

namespace Platform\Domain\Service;

use Framework\Http\Request\RequestContext;
use Platform\Domain\Repository\PageRepository;

class PageService extends EntityService
{
    /** @var RequestContext */
    private $requestContext;

    public function __construct(
        PageRepository $pageRepository,
        RequestContext $requestContext
    ) {
        parent::__construct($pageRepository);

        $this->requestContext = $requestContext;
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
        $request = $this->requestContext->getRequest();

        if ($page['slug'] === 'index') {
            return $request->getUrl();
        }

        return $request->getUrlForPath($page['slug']);
    }
}
