<?php

namespace Framework\Http\Bag;

use Framework\Http\Session\Session;

class FlashBag
{
    /** @var Session */
    private $session;

    private const KEY = 'flash';

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function has(?string $type = null): bool
    {
        $flashes = $this->session->get(self::KEY, []);

        if ($type === null) {
            return !empty($flashes);
        }

        return !empty($flashes[$type]);
    }

    /** @param mixed $message */
    public function add(string $type, $message): void
    {
        $flashes = $this->session->get(self::KEY, []);

        if (!isset($flashes[$type])) {
            $flashes[$type] = [];
        }

        $flashes[$type][] = $message;

        $this->session->set(self::KEY, $flashes);
    }

    public function get(string $type): array
    {
        $flashes = $this->session->get(self::KEY, []);

        if (!isset($flashes[$type])) {
            return [];
        }

        $messages = $flashes[$type];
        unset($flashes[$type]);

        $this->session->set(self::KEY, $flashes);

        return $messages;
    }

    public function all(): array
    {
        $flashes = $this->session->get(self::KEY, []);
        $this->clear();

        return $flashes;
    }

    public function clear(): void
    {
        $this->session->remove(self::KEY);
    }
}
