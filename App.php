<?php

use Config\DbConfig;
use Config\BotConfig;
use MrMuminov\PhpI18n\I18n;

class App
{
    public static DbConfig $database;
    public static bool $debug = false;
    public static BotConfig $bot;
    public static I18n $i18n;

    public function __construct(
        DbConfig  $database,
        BotConfig $bot,
        I18n      $i18n,
        bool      $debug = false,
    )
    {
        self::$database = $database;
        self::$bot = $bot;
        self::$debug = $debug;
        self::$i18n = $i18n;
    }

    public static function log(mixed $message): void
    {
        @fputs(@fopen('php://stdout', 'a+'), print_r($message, 1) . PHP_EOL);
    }

    public static function debug(mixed $message): void
    {
        @fputs(@fopen('php://stdout', 'a+'), var_export($message, 1) . PHP_EOL);
    }
}