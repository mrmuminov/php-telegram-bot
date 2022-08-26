<?php

namespace Config;

class BotConfig
{
    public function __construct(
        public readonly string $bot_api_token,
        public readonly string $bot_username,
        public readonly string $webhook_url,
    )
    {
    }
}