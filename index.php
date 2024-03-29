<?php

use Commands\HelloCommand;
use Commands\StartCommand;
use Longman\TelegramBot\Exception\TelegramException;

require __DIR__ . '/vendor/autoload.php';

if (App::$development) {
    ini_set(option: 'display_errors', value: 1);
    error_reporting(error_level: E_ALL);
}

try {
    App::init();
    App::$telegram->addCommandClasses([
        StartCommand::class,
        HelloCommand::class,
    ]);
    App::$telegram->handle();
} catch (TelegramException $e) {
    App::log($e);
}