<?php

namespace Platform\Security;

use Framework\Http\Session\Session;
use Framework\Security\AuthenticatedUser;
use Framework\Security\AuthenticatorInterface;
use Platform\Domain\Service\UserService;

class Authenticator implements AuthenticatorInterface
{
    /** @var Session */
    private $session;
    /** @var UserService */
    private $userService;

    private const KEY = 'user_id';

    public function __construct(
        Session $session,
        UserService $userService
    ) {
        $this->session = $session;
        $this->userService = $userService;
    }

    public function authenticated(): bool
    {
        return !!$this->user();
    }

    public function user(): ?AuthenticatedUser
    {
        $id = $this->session->get(self::KEY);

        if ($id === null) {
            return null;
        }

        return $this->resolveUser($id);
    }

    public function login(int $id): void
    {
        $this->session->regenerate();
        $this->session->set(self::KEY, $id);
    }

    public function logout(): void
    {
        $this->session->destroy();
    }

    private function resolveUser(int $id): ?AuthenticatedUser
    {
        $user = $this->userService->find($id);

        if ($user === null) {
            // @TODO exception ?
            return null;
        }

        return new AuthenticatedUser(
            $user['id'],
            $user['uid'],
            $user['email']
        );
    }
}
