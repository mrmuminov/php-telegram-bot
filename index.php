<?php

use Config\DbConfig;
use Config\BotConfig;
use Commands\HelloCommand;
use Commands\StartCommand;
use MrMuminov\PhpI18n\I18n;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

require __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config.php';
(new App(
    database: new DbConfig(
        host: $config['database']['host'],
        port: $config['database']['port'],
        username: $config['database']['username'],
        password: $config['database']['password'],
        dbname: $config['database']['dbname'],
        attributes: $config['database']['attributes'] ?? [],
    ),
    bot: new BotConfig(
        bot_api_token: $config['bot']['bot_api_token'],
        bot_username: $config['bot']['bot_username'],
        webhook_url: $config['bot']['webhook_url'],
    ),
    i18n: new I18n([
        'path' => $config['i18n']['path'],
        'languages' => $config['i18n']['languages'],
        'language' => $config['i18n']['language'],
    ]),
    params: $config['params'] ?? [],
    development: $config['development'] ?? false,
));

if (App::$development) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

try {
    $telegram = new Telegram(App::$bot->bot_api_token, App::$bot->bot_username);
    $telegram->deleteWebhook();
    $telegram->setWebhook(App::$bot->webhook_url, [
        'drop_pending_updates' => true,
    ]);
    $telegram->addCommandClasses([
        StartCommand::class,
        HelloCommand::class,
    ]);

    $telegram->handle();
} catch (TelegramException $e) {
App::log($e);
}