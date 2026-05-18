<?php

namespace Platform\Module\Admin\Service;

use Platform\Domain\Service\UserService;

class PasswordService
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function validate(string $email, string $token): bool
    {
        $user = $this->userService->find($email, 'email');

        return $user && $user['token'] === $token;
    }

    // public function recover() // @TODO

    // public function update() // @TODO
}
