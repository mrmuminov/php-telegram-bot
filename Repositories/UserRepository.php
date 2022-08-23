<?php

namespace Repositories;

use PDO;
use App;
use Models\User;
use PDOStatement;
use Enums\StatusEnum;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function delete(User|RepositoryInterface $model)
    {
        $this->beforeDelete();
        $this->afterDelete();
    }

    public function save(User|RepositoryInterface $model): void
    {
        $this->beforeSave();
        if ($model->is_new) {
            $this->_insert(User::tableName(), $model->attributes());
            $model->id = App::$database::$pdo->lastInsertId();
            $model->is_new = false;
        } else {
            $columns = $model->attributes();
            unset($columns['id']);
            $this->_update(User::tableName(), $columns, [
                'id' => $model->id,
            ]);
        }
        $this->afterSave();
    }

    public function getById(int $id): ?User
    {
        return $this->getOneBy([
            'id' => $id,
        ]);
    }

    private function getOneBy(array $conditions, string $select = '*'): ?User
    {
        $stmt = $this->createSelectQuery($conditions, $select);
        $stmt->execute();
        $fetched = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($fetched)) {
            return null;
        }
        return User::create(
            chat_id: $fetched['chat_id'],
            id: $fetched['id'],
            step: $fetched['step'],
            language: $fetched['language'],
            created_at: $fetched['created_at'],
            status: StatusEnum::from($fetched['status']),
        );
    }

    private function createSelectQuery(array $conditions, string $select): PDOStatement|false
    {
        $conditionSql = '';
        foreach ($conditions as $key => $value) {
            $conditionSql .= $key . ' = :' . $key;
        }
        if (empty($select)) {
            $select = '*';
        }
        $sql = 'SELECT ' . $select . ' FROM "' . User::tableName() . '" WHERE ' . $conditionSql;
        $stmt = App::$database::$pdo->prepare($sql);
        foreach ($conditions as $key => $value) {
            $stmt->bindParam(":" . $key, $value);
        }
        return $stmt;
    }

    public function getByChatId(int $chat_id): ?User
    {
        return $this->getOneBy([
            'chat_id' => $chat_id,
        ]);
    }

    private function getManyBy(array $conditions, string $select = '*'): array
    {
        $stmt = $this->createSelectQuery($conditions, $select);
        $stmt->execute();
        $fetched = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($fetched)) {
            return [];
        }
        $result = [];
        foreach ($fetched as $item) {
            $result[] = User::create(
                chat_id: $item['chat_id'],
                id: $item['id'],
                step: $item['step'],
                language: $item['language'],
                created_at: $item['created_at'],
                status: $item['status'],
            );
        }
        return $result;
    }
}