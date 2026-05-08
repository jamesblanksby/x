<?php

namespace Framework\View\Extension;

use Framework\View\View;

interface ExtensionInterface
{
    public function register(View $view): void;
}
