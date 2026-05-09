<?php

namespace Platform\Domain\Service;

use Platform\Domain\Repository\ImageRepository;

class ImageService extends EntityService
{
    /** @var FileService */
    private $fileService;

    public function __construct(
        FileService $fileService,
        ImageRepository $imageRepository
    ) {
        parent::__construct($imageRepository);

        $this->fileService = $fileService;
    }

    public function hydrate(array $image): array
    {
        $image['aspect'] = $this->aspect($image);
        $image['file'] = $this->fileService->find($image['file']);
        $image['orientation'] = $this->orientation($image);
        // @TODO variants

        return parent::hydrate($image);
    }

    private function aspect(array $image): float
    {
        return ($image['width'] / $image['height']);
    }

    private function orientation(array $image): string
    {
        $aspect = $this->aspect($image);

        return $aspect > 1 ? 'landscape' : ($aspect < 1 ? 'portrait' : 'square');
    }
}
