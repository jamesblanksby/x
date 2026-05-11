<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Response\Response;
use Platform\Controller\AdminController;

class IndexController extends AdminController
{
    public function index(): Response
    {
        return $this->redirectToRoute('admin.page.index');
    }
}
