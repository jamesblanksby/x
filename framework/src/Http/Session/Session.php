<?php

namespace Framework\Http\Session;

use Framework\Http\Bag\FlashBag;
use Framework\Support\ValueObject;

class Session extends ValueObject
{
    /** @var FlashBag */
    public $flash;

    /** @var bool */
    private $started = false;

    public function __construct()
    {
        $this->flash = new FlashBag($this);
    }

    public function start(): void
    {
        if ($this->started) {
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->started = true;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /** @param mixed $value */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clear(): void
    {
        $_SESSION = [];
    }

    public function destroy(): void
    {
        session_destroy();
        $this->clear();
    }

    public function regenerate(): void
    {
        if ($this->started) {
            session_regenerate_id(true);
        }
    }

    public function id(): string
    {
        return session_id();
    }
}
