<?php

namespace Platform\Module\Admin\Service;

use Platform\Domain\Service\UserService;
use Platform\Security\Authenticator;

class AuthService
{
    /** @var Authenticator */
    private $authenticator;
    /** @var UserService */
    private $userService;

    public function __construct(
        Authenticator $authenticator,
        UserService $userService
    ) {
        $this->authenticator = $authenticator;
        $this->userService = $userService;
    }

    public function authenticate(string $email, string $password): bool
    {
        $user = $this->userService->find($email, 'email');

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $this->authenticator->login($user['id']);

        return true;
    }

    public function logout(): void
    {
        $this->authenticator->logout();
    }
}
