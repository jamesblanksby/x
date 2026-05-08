<?php

namespace Platform\Module\Admin\Controller;

use Framework\Controller\Controller;
use Framework\Http\Response\Response;

class IndexController extends Controller
{
    public function index(): Response
    {
        return $this->redirectToRoute('admin.page.index');
    }
}
