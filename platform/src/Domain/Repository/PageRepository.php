<?php

namespace Platform\Domain\Repository;

use Framework\Database\Database;

class PageRepository extends EntityRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database, 'page', ['name' => 'ASC']);
    }
}
