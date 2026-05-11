<?php

namespace Platform\View\Extension;

use Framework\Http\Request\Request;
use Framework\View\Extension\AssetExtension;
use Framework\View\Extension\ExtensionInterface;
use Framework\View\View;
use Platform\Domain\Service\SettingService;

class PageExtension implements ExtensionInterface
{
    /** @var AssetExtension */
    private $assetExtension;
    /** @var Request */
    private $request;
    /** @var array */
    private $settings;

    public function __construct(
        AssetExtension $assetExtension,
        Request $request,
        SettingService $settingService
    ) {
        $this->assetExtension = $assetExtension;
        $this->request = $request;
        $this->settings = $settingService->map();
    }

    public function register(View $view): void
    {
        $view->addFunction('page_url', [$this, 'url']);
        $view->addFunction('page_title', [$this, 'title']);
        $view->addFunction('page_description', [$this, 'description']);
        $view->addFunction('page_image', [$this, 'image']);
    }

    public function url(?array $page): string
    {
        return $page['url'] ?? $this->request->getUrl();
    }

    public function title(?array $page): string
    {
        if (!$page) {
            return $this->settings['page.site'];
        }

        $title = $page['title'] ?? $this->settings['page.title'];

        $placeholders = [
            '{{SITE}}' => $this->settings['page.site'],
            '{{DIVIDER}}' => $this->settings['page.divider'],
            '{{PAGE}}' => $page['name'],
        ];

        return strtr($title, $placeholders);
    }

    public function description(?array $page): string
    {
        return $page['description'] ?? $this->settings['page.description'];
    }

    public function image(?array $page): string
    {
        $image = $page['images']['share']['variants']['large']['proxy'] ?? null;

        return $image ?? $this->assetExtension->asset('src/gfx/share.png');
    }
}
