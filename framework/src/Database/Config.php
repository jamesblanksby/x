<?php

namespace Framework\Database;

class Config
{
    /** @var string */
    public $driver;
    /** @var string */
    public $host;
    /** @var int */
    public $port;
    /** @var string */
    public $database;
    /** @var ?string */
    public $username;
    /** @var ?string */
    public $password;
    /** @var string */
    public $charset;

    public function __construct(array $config = [])
    {
        $config = array_merge(Config::defaults(), $config);

        $this->driver = $config['driver'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->database = $config['database'];
        $this->username = $config['username'];
        $this->password = $config['password'];
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

    public static function defaults(): array
    {
        return [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'database' => '',
            'username' => null,
            'password' => null,
            'charset' => 'utf8mb4',
        ];
    }
}
