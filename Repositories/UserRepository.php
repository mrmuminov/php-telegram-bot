<?php

namespace Repositories;

use Throwable;
use Models\User;
use Enums\StatusEnum;
use Yiisoft\Db\Exception\Exception;
use Yiisoft\ActiveRecord\ActiveQuery;
use Yiisoft\Db\Exception\StaleObjectException;
use Yiisoft\Db\Exception\InvalidConfigException;

class UserRepository extends BaseRepository
{
    public ?ActiveQuery $_query = null;
    public ?string $modelClass = User::class;

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function delete(User $model)
    {
        $model->delete();
    }

    /**
     * @throws StaleObjectException
     * @throws Exception
     */
    public function save(User $model): void
    {
        $model->save();
    }

    /**
     * @throws InvalidConfigException
     * @throws Throwable
     * @throws Exception
     */
    public function getByChatId(int $chat_id): ?User
    {
        return $this->getOneBy([
            'chat_id' => $chat_id,
        ]);
    }

    /**
     * @throws InvalidConfigException
     * @throws Throwable
     * @throws Exception
     */
    public function getOneBy(array $conditions = [], string $select = '*'): ?User
    {
        $data = $this->query()->select($select)
            ->where($conditions)
            ->one();

        if (empty($data)) {
            return null;
        }
        $model = $this->create(
            id: $data['id'],
            chat_id: $data['chat_id'],
            step: $data['step'],
            phone: $data['phone'],
            username: $data['username'],
            language: $data['language'],
            created_at: $data['created_at'],
            status: StatusEnum::from($data['status']),
        );
        $model->setIsNewRecord(false);
        $model->setOldAttributes($model->getAttributes());
        return $model;
    }

    public function create(
        ?int       $id = null,
        ?int       $chat_id = null,
        ?string    $step = null,
        ?string    $phone = null,
        ?string    $username = null,
        ?string    $language = null,
        ?int       $created_at = null,
        StatusEnum $status = StatusEnum::ACTIVE,
    ): User
    {
        $model = $this->model();
        if (!empty($id)) {
            $model->id = $id;
        }
        $model->chat_id = $chat_id;
        $model->step = $step;
        $model->phone = $phone;
        $model->username = $username;
        $model->language = $language;
        $model->status = $status->label();
        $model->created_at = $created_at;
        return $model;
    }

}