<?php

namespace Platform\Module\Common\Controller;

use Framework\Controller\Controller;
use Framework\Http\Response\FileResponse;
use Framework\Http\Response\Response;
use Platform\Domain\Service\FileService;

class FileController extends Controller
{
    /** @var FileService */
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function content(string $file, string $name): Response
    {
        $file = $this->fileService->get($file, 'uid');

        if ($file['name'] !== $name) {
            return $this->redirectToRoute('file.content', [
                'file' => $file['uid'],
                'name' => $file['name'],
            ], 301);
        }

        return new FileResponse($file['path'], $file['name']);
    }
}
