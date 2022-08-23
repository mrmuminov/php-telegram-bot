<?php

namespace Services;

use Models\User;
use Enums\StatusEnum;
use Repositories\UserRepository;

class UserService extends BaseService
{
    public UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function create(
        int        $chat_id,
        ?string    $step = null,
        ?string    $language = null,
        StatusEnum $status = StatusEnum::ACTIVE,
    )
    {
        $user = User::create(
            chat_id: $chat_id,
            step: $step,
            language: $language,
            created_at: time(),
            status: $status,
        );
        $this->userRepository->save($user);
    }

    public function getById(int $id): ?User
    {
        return $this->userRepository->getById($id);
    }

    public function getByChatId(int $chat_id): ?User
    {
        return $this->userRepository->getByChatId($chat_id);
    }

    public function update(User $user)
    {
        $this->userRepository->save($user);
    }
}