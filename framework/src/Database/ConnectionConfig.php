<?php

namespace Framework\Database;

class ConnectionConfig
{
    /** @var string */
    private $driver;
    /** @var string */
    private $host;
    /** @var int */
    private $port;
    /** @var string */
    private $database;
    /** @var string */
    private $charset;
    /** @var ?string */
    private $username;
    /** @var ?string */
    private $password;

    public function __construct(array $config = [])
    {
        $config = array_merge(self::defaults(), $config);

        $this->driver = $config['driver'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->database = $config['database'];
        $this->charset = $config['charset'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }

    public function getDsn(): string
    {
        return sprintf(
            '%s:host=%s;port=%d;dbname=%s;charset=%s',
            $this->driver,
            $this->host,
            $this->port,
            $this->database,
            $this->charset
        );
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
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
