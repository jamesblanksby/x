<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Platform\Controller\AdminController;
use Platform\Domain\Service\PageService;

class PageController extends AdminController
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
        $type = $request->getQuery()->get('type', 'system');

        $pages = $this->pageService->select($type);

        return $this->render('admin/template/page/page.list', [
            'pages' => $pages,
        ]);
    }

    // @TODO insert/update

    public function delete(string $page): Response
    {
        $page = $this->pageService->get($page, 'uid');
        $this->pageService->delete($page);

        return $this->respond([
            'success' => true,
            'message' => 'Page successfully deleted',
            'reload' => true,
        ]);
    }
}
