<?php

namespace Config;

use Yiisoft\Cache\ArrayCache;
use Yiisoft\Db\Cache\SchemaCache;
use Yiisoft\Db\Pgsql\ConnectionPDO;
use Yiisoft\Db\Pgsql\PDODriver;

class DbConfig
{
    public static ConnectionPDO $connection;
    public static PDODriver $driver;

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
        self::$driver = new PDODriver(
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
        self::$connection = new ConnectionPDO(
            driver: self::$driver,
            schemaCache: $this->schemaCache,
        );
    }
}