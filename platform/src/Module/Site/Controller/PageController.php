<?php

namespace Platform\Module\Site\Controller;

use Framework\Controller\Controller;
use Framework\Http\Response\Response;
use Platform\Domain\Service\PageService;

class PageController extends Controller
{
    /** @var PageService */
    private $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index(): Response
    {
        return $this->detail('index');
    }

    public function detail(string $page): Response
    {
        $page = $this->pageService->get($page, 'slug');

        return $this->render('site/view/page.detail', [
            'page' => $page,
        ]);
    }
}
