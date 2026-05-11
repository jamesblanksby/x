<?php

namespace Platform\Domain\Service;

use Platform\Domain\Repository\SettingRepository;

class SettingService extends EntityService
{
    public function __construct(SettingRepository $settingRepository)
    {
        parent::__construct($settingRepository);
    }

    public function map(): array
    {
        $settings = $this->repository->all();

        $map = [];
        foreach ($settings as $setting) {
            $map[$setting['key']] = $setting['value'];
        }

        return $map;
    }
}
