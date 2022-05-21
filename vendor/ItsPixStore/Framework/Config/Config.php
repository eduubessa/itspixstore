<?php

namespace ItsPixStore\Config;

use Dotenv\Dotenv;

class Config
{
    private static function loadEnvironment(): void
    {
        $dotenv = Dotenv::createImmutable(APP_PATH_ROOT);
        $dotenv->load();
    }

    public static function load(): void
    {
        self::loadEnvironment();
    }

    public static function get(string $variable, string $default = "") : string
    {
        return $default;
    }
}