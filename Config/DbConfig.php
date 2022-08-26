<?php

namespace Config;

use PDO;

class DbConfig
{
    public static PDO $pdo;

    public function __construct(
        private readonly string $schema = 'pgsql',
        private readonly string $host = 'localhost',
        private readonly int    $port = 5432,
        private readonly string $username = 'postgres',
        private readonly string $password = '',
        private readonly string $dbname = '',
        private readonly string $charset = 'utf8',
        private readonly array  $options = [],
    )
    {
        self::$pdo = new PDO(
            dsn: $this->schema . ':' .
            'host=' . $this->host . ';' .
            'port=' . $this->port . ';' .
            'dbname=' . $this->dbname . ';' .
            'charset=' . $this->charset . ';',
            username: $this->username,
            password: $this->password,
            options: $options
        );
    }
}