<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Exception\NotFoundException;
use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Platform\Controller\AdminController;
use Platform\Module\Admin\Form\Type\PasswordFormType;
use Platform\Module\Admin\Form\Type\PasswordRecoverType;
use Platform\Module\Admin\Service\PasswordService;

class PasswordController extends AdminController
{
    /** @var PasswordService */
    private $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function update(
        Request $request,
        string $token
    ): Response {
        $email = $request->getQuery()->get('email', '');

        $success = $this->passwordService->validate($email, $token);

        if (!$success) {
            throw new NotFoundException();
        }

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
}
