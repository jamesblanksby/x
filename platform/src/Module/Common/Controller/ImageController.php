<?php

namespace Platform\Module\Common\Controller;

use Framework\Controller\Controller;
use Framework\Http\Request\Request;
use Framework\Http\Response\FileResponse;
use Framework\Http\Response\Response;
use Platform\Domain\Service\ImageService;

class ImageController extends Controller
{
    /** @var ImageService */
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function content(Request $request, string $image, string $name): Response
    {
        $image = $this->imageService->get($image, 'uid');

        $file = $image['file'];

        if ($file['name'] !== $name) {
            return $this->redirectToRoute('image.content', [
                'image' => $image['uid'],
                'name' => $file['name'],
            ], 301);
        }

        $size = $request->getQuery()->get('size');
        $path = $image['variants'][$size]['path'] ?? $file['path'];

        return new FileResponse($path, $file['name']);
    }
}
