<?php

namespace Platform\Domain\Service;

use Platform\Domain\Repository\UserRepository;

class UserService extends EntityService
{
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }
}
