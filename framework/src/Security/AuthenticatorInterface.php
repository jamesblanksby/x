<?php

namespace Framework\Security;

interface AuthenticatorInterface
{
    public function check(): ?AuthenticatedUser;

    public function authenticate(int $id): void;

    public function invalidate(): void;
}
