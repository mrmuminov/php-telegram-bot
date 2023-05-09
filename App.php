<?php

use Config\BotConfig;
use Config\DbConfig;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Telegram;
use MrMuminov\PhpI18n\I18n;

class App
{
    public static DbConfig $database;
    public static Telegram $telegram;
    public static bool $development = false;
    public static BotConfig $bot;
    public static I18n $i18n;
    public static array $params = [];

    public function __construct(
        DbConfig  $database,
        BotConfig $bot,
        I18n      $i18n,
        array     $params = [],
        bool      $development = false,
    )
    {
        self::$database = $database;
        self::$bot = $bot;
        self::$development = $development;
        self::$i18n = $i18n;
        self::$params = $params;
    }

    public static function log(mixed $message): void
    {
        @fputs(@fopen(filename: 'php://stdout', mode: 'a+'), print_r($message, 1) . PHP_EOL);
    }

    public static function debug(mixed $message): void
    {
        @fputs(@fopen(filename: 'php://stdout', mode: 'a+'), var_export($message, 1) . PHP_EOL);
    }

    public static function init(): void
    {
        if (isset(self::$telegram)) {
            return;
        }
        if (!file_exists(__DIR__ . '/config.php')) {
            throw new Exception(
                message: "config.php file not found." . PHP_EOL .
                "Please, copy config.example.php to name config.php and try again."
            );
        }
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


        self::$telegram = new Telegram(
            api_key: App::$bot->bot_api_token,
            bot_username: App::$bot->bot_username,
        );

    }

    public static function setWebHook(
        string $url = null,
        mixed  $certificate = null,
        string $ipAddress = null,
        string $maxConnections = null,
        string $allowedUpdates = null,
        string $dropPendingUpdates = null,
        string $secretToken = null,
    ): ServerResponse
    {
        $data = [];
        if ($certificate) $data['certificate'] = $certificate;
        if ($ipAddress) $data['ip_address'] = $ipAddress;
        if ($maxConnections) $data['max_connections'] = $maxConnections;
        if ($allowedUpdates) $data['allowed_updates'] = $allowedUpdates;
        if ($dropPendingUpdates) $data['drop_pending_updates'] = $dropPendingUpdates;
        if ($secretToken) $data['secret_token'] = $secretToken;
        return self::$telegram->setWebhook(
            url: $url ?? App::$bot->webhook_url,
            data: $data,
        );
    }
}