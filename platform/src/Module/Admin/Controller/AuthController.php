<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Platform\Controller\AdminController;
use Platform\Module\Admin\Service\AuthService;

class AuthController extends AdminController
{
    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(): Response
    {
        return $this->render('admin/template/login');
    }

    public function authenticate(Request $request): Response
    {
        $input = $request->input->all();

        $email = $input['email'];
        $password = $input['password'];

        $success = $this->authService->authenticate($email, $password);

        if (!$success) {
            return $this->respond([
                'success' => false,
                'text' => 'Invalid login credentials',
            ]);
        }

        $redirect = $request->query->get('redirect', $this->generateUrl('admin.page.index'));

        return $this->respond([
            'success' => true,
            'redirect' => $redirect,
        ]);
    }

    public function logout(): Response
    {
        $this->authService->logout();

        return $this->redirectToRoute('admin.page.index');
    }
}
