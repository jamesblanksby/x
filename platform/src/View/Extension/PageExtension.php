<?php

namespace Platform\View\Extension;

use Framework\Http\Request\RequestContext;
use Framework\View\Extension\AssetExtension;
use Framework\View\Extension\ExtensionInterface;
use Framework\View\View;
use Platform\Domain\Service\SettingService;

class PageExtension implements ExtensionInterface
{
    /** @var AssetExtension */
    private $assetExtension;
    /** @var RequestContext */
    private $requestContext;
    /** @var SettingService */
    private $settingService;
    /** @var ?array */
    private $settings = null;

    public function __construct(
        AssetExtension $assetExtension,
        RequestContext $requestContext,
        SettingService $settingService
    ) {
        $this->assetExtension = $assetExtension;
        $this->requestContext = $requestContext;
        $this->settingService = $settingService;
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
        return $page['url'] ?? $this->requestContext->getRequest()->getUrl();
    }

    public function title(?array $page): string
    {
        if ($page === null) {
            return $this->getSetting('page.site');
        }

        $title = $page['title'] ?? $this->getSetting('page.title');

        $placeholders = [
            '{{SITE}}' => $this->getSetting('page.site'),
            '{{DIVIDER}}' => $this->getSetting('page.divider'),
            '{{PAGE}}' => $page['name'],
        ];

        return strtr($title, $placeholders);
    }

    public function description(?array $page): string
    {
        return $page['description'] ?? $this->getSetting('page.description');
    }

    public function image(?array $page): string
    {
        $image = $page['images']['share']['variants']['large']['proxy'] ?? null;

        return $image ?? $this->assetExtension->asset('src/gfx/share.png');
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    private function getSetting(string $key, $default = null)
    {
        if ($this->settings === null) {
            $this->settings = $this->settingService->map();
        }

        return $this->settings[$key] ?? $default;
    }
}
