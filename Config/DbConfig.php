<?php

namespace Config;

use Yiisoft\Cache\Cache;
use Yiisoft\Cache\ArrayCache;
use Yiisoft\Db\Pgsql\PDODriver;
use Yiisoft\Db\Cache\QueryCache;
use Yiisoft\Db\Cache\SchemaCache;
use Yiisoft\Db\Pgsql\ConnectionPDO;

class DbConfig
{
    public static ConnectionPDO $connection;
    public static PDODriver $driver;

    public function __construct(
        private readonly string $host = 'localhost',
        private readonly int    $port = 5432,
        private readonly string $username = 'postgres',
        private readonly string $password = '',
        private readonly string $dbname = '',
        private readonly array  $attributes = [],
        private ?QueryCache     $queryCache = null,
        private ?SchemaCache    $schemaCache = null,
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
        $handler = new ArrayCache();
        if (is_null($this->queryCache)) {
            $this->queryCache = new QueryCache(
                cache: new Cache($handler, 3600)
            );
        }
        if (is_null($this->schemaCache)) {
            $this->schemaCache = new SchemaCache(
                cache: new Cache($handler, 3600)
            );
        }
        self::$connection = new ConnectionPDO(
            driver: self::$driver,
            queryCache: $this->queryCache,
            schemaCache: $this->schemaCache,
        );
    }
}