<?php

namespace Platform\Domain\Service;

use Platform\Domain\Repository\UserRepository;

class UserService extends EntityService
{
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }

    public function hydrate(array $user): array
    {
        $user['active'] = !!$user['password'];

        return parent::hydrate($user);
    }
}
