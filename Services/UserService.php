<?php

namespace Services;

use Models\User;
use Repositories\UserRepository;
use Throwable;
use Yiisoft\Db\Exception\Exception;
use Yiisoft\Db\Exception\InvalidConfigException;
use Yiisoft\Db\Exception\StaleObjectException;

class UserService extends BaseService
{
    public UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws StaleObjectException
     * @throws Exception
     */
    public function create(
        ?int    $id = null,
        ?int    $chat_id = null,
        ?string $step = null,
        ?string $phone = null,
        ?string $username = null,
        ?string $language = null,
        string  $status = 'ACTIVE',
    )
    {
        $user = $this->userRepository->create(
            id: $id,
            chat_id: $chat_id,
            step: $step,
            phone: $phone,
            username: $username,
            language: $language,
            created_at: time(),
            status: $status,
        );
        $this->userRepository->save($user);
    }

    /**
     * @throws StaleObjectException
     * @throws Exception
     */
    public function save(User $user)
    {
        $this->userRepository->save($user);
    }

    /**
     * @throws InvalidConfigException
     * @throws Throwable
     * @throws Exception
     */
    public function getByChatId(int $chat_id): ?User
    {
        return $this->userRepository->getByChatId($chat_id);
    }

    /**
     * @throws InvalidConfigException
     * @throws Throwable
     * @throws Exception
     */
    public function update(array $condition, array $attributes)
    {
        $user = $this->userRepository->getOneBy($condition);
        $user->setAttributes($attributes);
        $this->userRepository->save($user);
    }

    public function changeStep(User $user, string $step)
    {
        $user->step = $step;
    }

}