<?php

namespace Platform\Controller;

use Framework\Controller\Controller;
use Framework\Http\Request\RequestContext;
use Framework\Http\Response\Response;
use Platform\Form\Form;
use Platform\Form\FormFactory;

abstract class AdminController extends Controller
{
    protected function respond(array $data): Response
    {
        $request = $this->container->get(RequestContext::class)->getRequest();

        $success = $data['success'] ?? true;
        $status = $success ? 200 : 400;

        if ($request->isJson()) {
            return $this->json($data, $status);
        }

        $message = $data['message'] ?? null;
        $redirect = $data['redirect'] ?? null;

        if ($message) {
            $type = $success ? 'success' : 'error';
            $this->addFlash($type, $message);
        }

        if ($redirect) {
            $status = $success ? 302 : 303;
            return $this->redirect($redirect, $status);
        }

        return $this->status($status);
    }

    protected function createForm(string $type, array $data = [], array $options = []): Form
    {
        return $this->container->get(FormFactory::class)->create($type, $data, $options);
    }
}
