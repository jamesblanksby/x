<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Platform\Controller\AdminController;
use Platform\Module\Admin\Form\Type\PasswordRecoverType;
use Platform\Module\Admin\Form\Type\PasswordFormType;

class PasswordController extends AdminController
{
    public function insert(
        Request $request,
        string $token
    ): Response {
        // @TODO validate email & token
        $email = $request->getQuery()->get('email');

        $form = $this->createForm(PasswordFormType::class, [
            'email' => $email,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // @TODO
        }

        return $this->render('admin/template/password/password.form', [
            'form' => $form,
        ]);
    }

    public function recover(Request $request): Response
    {
        $form = $this->createForm(PasswordRecoverType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // @TODO
        }

        return $this->render('admin/template/password/password.recover', [
            'form' => $form,
        ]);
    }

    public function update(
        Request $request,
        string $token
    ): Response {
        // @TODO validate email & token
        $email = $request->getQuery()->get('email');

        $form = $this->createForm(PasswordFormType::class, [
            'email' => $email,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // @TODO
        }

        return $this->render('admin/template/password/password.form', [
            'form' => $form,
        ]);
    }
}
