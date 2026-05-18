<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Platform\Controller\AdminController;
use Platform\Module\Admin\Form\Type\LoginFormType;
use Platform\Module\Admin\Service\AuthService;

class AuthController extends AdminController
{
    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $email = $form->getValue('email');
            // $password = $form->getValue('password');

            $success = $this->authService->authenticate($email, $password);

            if (!$success) {
                return $this->respond([
                    'success' => false,
                    'message' => 'Invalid login credentials',
                ]);
            }

            $redirect = $request->getQuery()->get('redirect', $this->generateUrl('admin.page.index'));

            return $this->respond([
                'success' => true,
                'redirect' => $redirect,
            ]);
        }

        return $this->render('admin/template/login', [
            'form' => $form,
        ]);
    }

    public function logout(): Response
    {
        $this->authService->logout();

        return $this->redirectToRoute('admin.page.index');
    }
}
