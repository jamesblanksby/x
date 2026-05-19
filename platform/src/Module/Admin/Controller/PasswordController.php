<?php

namespace Platform\Module\Admin\Controller;

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

    public function recover(Request $request): Response
    {
        $form = $this->createForm(PasswordRecoverType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getValue('email');

            $this->passwordService->recover($email);

            $redirect = $request->getQuery()->get('redirect', $this->generateUrl('admin.page.index'));

            return $this->respond([
                'success' => true,
                'redirect' => $redirect,
            ]);
        }

        return $this->render('admin/template/password/password.recover', [
            'form' => $form,
        ]);
    }

    public function update(
        Request $request,
        string $token
    ): Response {
        $user = $this->passwordService->resolve($token);

        $form = $this->createForm(PasswordFormType::class, [
            'email' => $user['email'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->getValue('password');

            $this->passwordService->update($user['email'], $password);

            $redirect = $request->getQuery()->get('redirect', $this->generateUrl('admin.page.index'));

            return $this->respond([
                'success' => true,
                'redirect' => $redirect,
            ]);
        }

        return $this->render('admin/template/password/password.form', [
            'form' => $form,
        ]);
    }
}
