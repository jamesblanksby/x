<?php

namespace Platform\View\Extension;

use Framework\View\Extension\ExtensionInterface;
use Framework\View\View;
use Platform\Utility\Html;

class HtmlExtension implements ExtensionInterface
{
    public function register(View $view): void
    {
        $view->addFunction('html_attribute', [Html::class, 'attribute']);
        $view->addFunction('html_class', [Html::class, 'class']);
        $view->addFunction('html_equal', [Html::class, 'equal']);
        $view->addFunction('html_sanitize', [Html::class, 'sanitize']);
        $view->addFunction('html_state', [Html::class, 'state']);
        $view->addFunction('html_style', [Html::class, 'style']);
    }
}
