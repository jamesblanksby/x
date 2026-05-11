<?php

namespace Framework\Controller;

use Framework\Container\Container;
use Framework\Http\Response\FileResponse;
use Framework\Http\Response\JsonResponse;
use Framework\Http\Response\RedirectResponse;
use Framework\Http\Response\Response;
use Framework\Http\Router\Router;
use Framework\Http\Session\Session;
use Framework\View\View;

abstract class Controller
{
    /** @var Container */
    protected $container;

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    protected function redirect(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    protected function redirectToRoute(string $route, array $params = [], int $status = 302): RedirectResponse
    {
        return $this->redirect($this->generateUrl($route, $params), $status);
    }

    protected function status(int $status = 200): Response
    {
        return new Response('', $status);
    }

    /** @param mixed $data */
    protected function json($data, int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    protected function file(string $path, ?string $name, bool $download = false): FileResponse
    {
        return new FileResponse($path, $name, $download);
    }

    protected function render(string $template, array $data = []): Response
    {
        $body = $this->container->get(View::class)->render($template, $data);

        return new Response($body);
    }

    protected function generateUrl(string $name, array $params = [], bool $absolute = true): string
    {
        return $this->container->get(Router::class)->url($name, $params, $absolute);
    }

    protected function addFlash(string $type, string $message): void
    {
        $this->container->get(Session::class)->flash->add($type, $message);
    }
}
