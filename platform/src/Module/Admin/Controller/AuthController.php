<?php

namespace Platform\Module\Admin\Controller;

use Framework\Controller\Controller;
use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Platform\Module\Admin\Service\AuthService;

class AuthController extends Controller
{
    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(): Response
    {
        return $this->render('admin/view/login');
    }

    public function authenticate(Request $request): Response
    {
        $input = $request->body->all();

        $email = $input['email'];
        $password = $input['password'];

        $success = $this->authService->authenticate($email, $password);

        if (!$success) {
            return $this->json([
                'success' => false,
                'text' => 'Invalid login credentials',
            ]);
        }

        $redirect = $request->query->get('redirect', $this->generateUrl('admin.page.index'));

        return $this->json([
            'success' => true,
            'redirect' => $redirect,
        ]);
    }

    public function logout(): Response
    {
        $this->authService->invalidate();

        return $this->redirectToRoute('admin.page.index');
    }
}
