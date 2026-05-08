<?php

namespace Platform\Domain\Service;

use Framework\Core\Context;
use Framework\Http\Router\UrlGenerator;
use Platform\Domain\Repository\FileRepository;

class FileService extends EntityService
{
    /** @var Context */
    private $context;
    /** @var UrlGenerator */
    private $urlGenerator;

    public function __construct(
        Context $context,
        FileRepository $fileRepository,
        UrlGenerator $urlGenerator
    ) {
        parent::__construct($fileRepository);

        $this->context = $context;
        $this->urlGenerator = $urlGenerator;
    }

    public function hydrate(array $file): array
    {
        $file['path'] = $this->path($file);
        $file['url'] = $this->url($file);

        return parent::hydrate($file);
    }

    private function path(array $file): string
    {
        $name = $file['id'] . '.' . $file['extension'];

        return $this->context->path("lib/file/{$name}");
    }

    private function url(array $file): string
    {
        $params = [
            'file' => $file['uid'],
            'name' => $file['name'],
        ];

        return $this->urlGenerator->generate('file.content', $params, true);
    }
}
