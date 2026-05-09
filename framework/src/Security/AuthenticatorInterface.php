<?php

namespace Framework\Security;

interface AuthenticatorInterface
{
    public function authenticated(): bool;

    public function user(): ?AuthenticatedUser;

    public function login(int $id): void;

    public function logout(): void;
}
