<?php

use Config\DbConfig;
use Config\BotConfig;
use MrMuminov\PhpI18n\I18n;

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