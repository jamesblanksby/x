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
        $type = $request->query->get('type', 'system');

        $pages = $this->pageService->select($type);

        return $this->render('admin/template/page/page.list', [
            'pages' => $pages,
        ]);
    }

    public function new(): Response
    {
        return $this->render('admin/template/page/page.form', [
            'types' => [], // @TODO
        ]);
    }

    public function insert(Request $request): Response
    {
        $input = $request->input->all();

        $page = $this->pageService->insert($input);

        $redirect = $this->generateUrl('admin.page.edit', [
            'page' => $page['uid'],
            'redirect' => $request->query->get('redirect'),
        ]);

        return $this->respond([
            'success' => true,
            'text' => 'Page successfully created',
            'redirect' => $redirect,
        ]);
    }

    public function edit(string $page): Response
    {
        $page = $this->pageService->get($page, 'uid');

        return $this->render('admin/template/page/page.form', [
            'types' => [], // @TODO
            'page' => $page,
        ]);
    }

    public function update(Request $request, string $page): Response
    {
        $input = $request->input->all();

        $page = $this->pageService->get($page, 'uid');
        $this->pageService->update($page, $input);

        $redirect = $this->generateUrl('admin.page.edit', [
            'page' => $page['uid'],
            'redirect' => $request->query->get('redirect'),
        ]);

        return $this->respond([
            'text' => 'Page successfully updated',
            'redirect' => $redirect,
        ]);
    }

    public function delete(string $page): Response
    {
        $page = $this->pageService->get($page, 'uid');
        $this->pageService->delete($page);

        return $this->respond([
            'success' => true,
            'text' => 'Page successfully deleted',
            'reload' => true,
        ]);
    }
}
