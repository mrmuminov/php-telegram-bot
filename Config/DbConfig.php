<?php

namespace Config;

use PDO;

class DbConfig
{
    public static PDO $pdo;

    public function __construct(
        public string $schema = 'pgsql',
        public string $host = 'localhost',
        public int    $port = 5432,
        public string $username = 'postgres',
        public string $password = '',
        public string $dbname = '',
        public string $charset = 'utf8',
    )
    {
        self::$pdo = new PDO(
            dsn: $this->schema . ':' .
            'host=' . $this->host . ';' .
            'port=' . $this->port . ';' .
            'dbname=' . $this->dbname . ';',
            username: $this->username,
            password: $this->password,
        );
    }
}