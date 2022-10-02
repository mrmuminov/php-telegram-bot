<?php

namespace Commands;

use App;
use Throwable;
use Services\UserService;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Yiisoft\Db\Exception\Exception;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Commands\UserCommand;
use Yiisoft\Db\Exception\StaleObjectException;
use Yiisoft\Db\Exception\InvalidConfigException;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

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

    /**
     * @throws InvalidConfigException
     * @throws StaleObjectException
     * @throws Exception
     * @throws Throwable
     * @throws TelegramException
     */
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