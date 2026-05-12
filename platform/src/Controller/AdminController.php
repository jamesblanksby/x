<?php

namespace Platform\Controller;

use Framework\Controller\Controller;
use Framework\Http\Response\Response;
use Platform\Form\Form;
use Platform\Form\FormFactory;

abstract class AdminController extends Controller
{
    protected function respond(array $data): Response
    {
        // @TODO redirect

        return $this->json($data);
    }

    public function createForm(string $type, array $data = []): Form
    {
        return $this->container->get(FormFactory::class)->create($type, $data);
    }
}
