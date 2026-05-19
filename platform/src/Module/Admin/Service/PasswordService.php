<?php

namespace Platform\Module\Admin\Service;

use Framework\Http\Exception\NotFoundException;
use Platform\Domain\Service\UserService;

class PasswordService
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function resolve(string $token): array
    {
        $user = $this->userService->find($token, 'token');

        if (!$user) {
            throw new NotFoundException();
        }

        return $user;
    }

    public function recover(string $email): void
    {
        // @TODO
    }

    public function update(string $email, string $password): void
    {
        // @TODO
    }
}
