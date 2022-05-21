<?php

function env($variable, $default = "") : string {
    $config = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $config->load();

    return getenv($variable) ?: $default;
}