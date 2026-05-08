<?php

namespace Framework\Security;

class AuthenticatedUser
{
    /** @var int */
    public $id;
    /** @var mixed */
    public $identifier;
    /** @var string */
    public $email;

    /** @param mixed $identifier */
    public function __construct(int $id, $identifier, string $email)
    {
        $this->id = $id;
        $this->identifier = $identifier;
        $this->email = $email;
    }
}
