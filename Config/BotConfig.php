<?php

namespace Config;

class BotConfig
{
    public function __construct(
        public string $bot_api_token,
        public string $bot_username,
        public string $webhook_url,
    )
    {
    }
}