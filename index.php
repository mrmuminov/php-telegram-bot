<?php

use Config\DbConfig;
use Config\BotConfig;
use Commands\HelloCommand;
use Commands\StartCommand;
use MrMuminov\PhpI18n\I18n;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

require __DIR__ . '/vendor/autoload.php';
(new App(
    database: new DbConfig(
        username: "postgres",
        password: "",
        dbname: "<db-name>"
    ),
    bot: new BotConfig(
        bot_api_token: '<bot-api-token>',
        bot_username: '<bot-username>',
        webhook_url: "<webhook_url>",
    ),
    i18n: new I18n([
        'path' => __DIR__ . '/Locales',
        'languages' => ['en'],
        'language' => 'en',
    ]),
    debug: true,
));

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