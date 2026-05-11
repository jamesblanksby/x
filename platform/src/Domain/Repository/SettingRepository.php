<?php

namespace Platform\Domain\Repository;

use Framework\Database\Database;

class SettingRepository extends EntityRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database, 'setting');
    }
}
