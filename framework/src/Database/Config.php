<?php

namespace Framework\Database;

use Framework\Support\ImmutableObject;

class Config extends ImmutableObject
{
    /** @var string */
    public $driver;
    /** @var ?string */
    public $username;
    /** @var ?string */
    public $password;

    /** @var string */
    private $host;
    /** @var int */
    private $port;
    /** @var string */
    private $database;
    /** @var string */
    private $charset;

    public function __construct(array $config = [])
    {
        $config = array_merge(self::defaults(), $config);

        $this->driver = $config['driver'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->database = $config['database'];
        $this->charset = $config['charset'];
    }

    public function dsn(): string
    {
        return sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $this->host,
            $this->port,
            $this->database,
            $this->charset
        );
    }

    private static function defaults(): array
    {
        return [
            'driver' => 'mysql',
            'username' => null,
            'password' => null,
            'host' => '127.0.0.1',
            'port' => 3306,
            'database' => '',
            'charset' => 'utf8mb4',
        ];
    }
}
