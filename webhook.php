<?php

use Longman\TelegramBot\Exception\TelegramException;

require __DIR__ . '/vendor/autoload.php';

if (App::$development) {
    ini_set(option: 'display_errors', value: 1);
    error_reporting(error_level: E_ALL);
}

try {
    App::init();
    App::log(App::setWebHook(dropPendingUpdates: true));
} catch (TelegramException $e) {
    App::log($e);
}