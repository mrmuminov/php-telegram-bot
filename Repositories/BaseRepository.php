<?php

namespace Repositories;

use PDO;
use App;
use PDOException;

abstract class BaseRepository implements RepositoryInterface
{

    public function __construct()
    {
    }

    public static function afterDelete(): void
    {
    }

    public static function afterSave(): void
    {
    }

    public static function beforeDelete(): void
    {
    }

    public static function beforeSave(): void
    {
    }

    protected function _insert($tableName, $columns): void
    {
        $keys = '';
        $values = '';
        $params = [];
        foreach ($columns as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $params[':' . $key] = $value;
            $keys .= ', "' . $key . '"';
            $values .= ', :' . $key;
        }
        $sql = 'INSERT INTO "' . $tableName . '" (' . ltrim($keys, ', ') . ') VALUES (' . ltrim($values, ', ') . ')';
        $stmt = App::$database::$pdo->prepare($sql);
        $stmt->execute($params);
    }

    protected function _update($tableName, $columns, $conditions): void
    {
        $values = '';
        $params = [];
        $conditionSql = '';
        foreach ($conditions as $key => $value) {
            $conditionSql.= ', ' . $key . ' = :' . $key;
            $params[':' . $key] = $value;
        }
        foreach ($columns as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $params[':' . $key] = $value;
            $values .= ', "' . $key . '" = :' . $key;
        }
        $sql = 'UPDATE "' . $tableName . '" SET ' . ltrim($values, ', ') . ' WHERE ' . ltrim($conditionSql, ', ');
        $stmt = App::$database::$pdo->prepare($sql);
        $stmt->execute($params);
    }
}