<?php

namespace Config;

use Yiisoft\Cache\ArrayCache;
use Yiisoft\Db\Cache\SchemaCache;
use Yiisoft\Db\Pgsql\Connection;
use Yiisoft\Db\Pgsql\Driver;

class DbConfig
{
    public static Connection $connection;
    public static Driver $driver;

    public function __construct(
        private string       $host = 'localhost',
        private int          $port = 5432,
        private string       $username = 'postgres',
        private string       $password = '',
        private string       $dbname = '',
        private array        $attributes = [],
        private ?SchemaCache $schemaCache = null,
    )
    {
        self::$driver = new Driver(
            dsn: 'pgsql:' .
            'host=' . $this->host . ';' .
            'port=' . $this->port . ';' .
            'dbname=' . $this->dbname . ';',
            username: $this->username,
            password: $this->password,
            attributes: $this->attributes);
        $arrayCache = new ArrayCache();
        if (is_null($this->schemaCache)) {
            $this->schemaCache = new SchemaCache(
                psrCache: $arrayCache
            );
        }
        self::$connection = new Connection(
            driver: self::$driver,
            schemaCache: $this->schemaCache,
        );
    }
}