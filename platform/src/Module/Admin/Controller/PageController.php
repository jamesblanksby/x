<?php

namespace Platform\Module\Admin\Controller;

use Framework\Controller\Controller;
use Framework\Http\Request\Request;
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

    public function index(Request $request): Response
    {
        return $this->list($request);
    }

    public function list(Request $request): Response
    {
        $type = $request->query->get('type', 'system');

        $pages = $this->pageService->select($type);

        return $this->render('admin/view/page/page.index', [
            'pages' => $pages,
        ]);
    }
}
