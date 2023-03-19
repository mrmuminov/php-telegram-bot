<?php

namespace Commands;

use App;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Services\UserService;

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
        $chat = $this->getMessage()->getChat();
        $from = $this->getMessage()->getFrom();
        $user = $this->userService->getByChatId($chat->getId());
        if ($user === null) {
            $this->userService->create(
                chat_id: $chat->getId(),
                step: 'start',
                username: $chat->getUsername(),
                language: $from->getLanguageCode(),
            );
            return Request::sendMessage([
                'chat_id' => $chat->getId(),
                'text' => App::$i18n->get("Hello"),
            ]);
        }
        if ($user->language !== $from->getLanguageCode()) {
            $user->language = $from->getLanguageCode();
        }
        if ($user->username !== $chat->getUsername()) {
            $user->username = $chat->getUsername();
        }
        $this->userService->changeStep($user, 'start');
        $this->userService->save($user);
        return Request::sendMessage([
            'chat_id' => $chat->getId(),
            'text' => App::$i18n->get("Home"),
        ]);
    }
}