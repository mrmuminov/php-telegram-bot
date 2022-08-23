<?php

namespace Commands;

use App;
use Services\UserService;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class StartCommand extends UserCommand
{
    protected $name = 'start';
    protected $description = 'A command for Start';
    protected $usage = '/start';
    protected $version = '1.0.0';

    protected UserService $userService;

    public function __construct(Telegram $telegram, ?Update $update = null)
    {
        $this->userService = new UserService();
        parent::__construct(telegram: $telegram, update: $update);
    }

    public function execute(): ServerResponse
    {
        $chat_id = $this->getMessage()->getChat()->getId();
        $user = $this->userService->getByChatId($chat_id);
        if ($user === null) {
            $this->userService->create(
                chat_id: $chat_id,
                step: 'start',
            );
            return Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => App::$i18n->get("Hello"),
            ]);
        }
        $user->step = 'start';
        $this->userService->update($user);
        return Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => App::$i18n->get("Home"),
        ]);
    }
}