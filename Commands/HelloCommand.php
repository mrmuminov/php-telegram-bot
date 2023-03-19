<?php

namespace Commands;

use App;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Services\UserService;

class HelloCommand extends UserCommand
{
    protected $name = 'hello';
    protected $description = 'A command for hello';
    protected $usage = '/hello';
    protected $version = '1.0.0';
    protected UserService $userService;

    public function __construct(
        Telegram $telegram,
        ?Update  $update = null,
    )
    {
        $this->userService = new UserService();
        parent::__construct($telegram, $update);
    }

    public function execute(): ServerResponse
    {
        $chat_id = $this->getMessage()->getChat()->getId();
        $user = $this->userService->getByChatId($chat_id);
        if ($user === null) {
            return Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => App::$i18n->get("Please, send /start command!"),
            ]);
        }
        $this->userService->changeStep($user, 'hello');
        $this->userService->save($user);
        return Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => App::$i18n->get("Hello"),
        ]);
    }
}