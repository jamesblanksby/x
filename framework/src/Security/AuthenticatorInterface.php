<?php

namespace Framework\Security;

interface AuthenticatorInterface
{
    public function login(int $id): void;

    public function logout(): void;

    public function getUser(): ?AuthenticatedUser;

    public function isAuthenticated(): bool;
}
