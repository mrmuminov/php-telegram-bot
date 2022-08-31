<?php

use Commands\HelloCommand;
use Commands\StartCommand;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/init.php';

if (App::$debug) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

try {
    $telegram = new Telegram(App::$bot->bot_api_token, App::$bot->bot_username);

    $telegram->addCommandClasses([
        StartCommand::class,
        HelloCommand::class,
    ]);

    $telegram->handle();
} catch (TelegramException $e) {

}