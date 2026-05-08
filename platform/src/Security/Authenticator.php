<?php

namespace Platform\Security;

use Framework\Security\AuthenticatedUser;
use Framework\Security\AuthenticatorInterface;
use Platform\Domain\Service\UserService;

class Authenticator implements AuthenticatorInterface
{
    /** @var UserService */
    private $userService;

    private const AUTH_KEY = 'user_id';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->session();
    }

    public function check(): ?AuthenticatedUser
    {
        $id = $_SESSION[self::AUTH_KEY] ?? null;

        if (!$id) {
            return null;
        }

        return $this->user($id);
    }

    public function authenticate(int $id): void
    {
        session_regenerate_id(true);
        $_SESSION[self::AUTH_KEY] = $id;
    }

    public function invalidate(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    private function user(int $id): ?AuthenticatedUser
    {
        $user = $this->userService->find($id);

        if (!$user) {
            return null;
        }

        return new AuthenticatedUser(
            $user['id'],
            $user['email']
        );
    }

    private function session(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
