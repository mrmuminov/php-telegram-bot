<?php

return [
    'database' => [
        'schema' => 'pgsql',
        'host' => 'localhost',
        'port' => 5432,
        'username' => 'postgres',
        'password' => '',
        'dbname' => '',
        'charset' => 'UTF8',
        'options' => [],
    ],
    'bot' => [
        'bot_api_token' => '000000:AAAAAABBBBBBCCCCCC',
        'bot_username' => 'username_bot',
        'webhook_url' => 'https://yoursite.com/path/index.php',
    ],
    'i18n' => [
        'path' => __DIR__ . '/Locales',
        'languages' => ['en'],
        'language' => 'en',
    ],
    'params' => [],
    'debug' => true,
];