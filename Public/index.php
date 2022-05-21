<?php

use ItsPixStore\Config\Config;

if(file_exists(__DIR__ . '/../Bootstrap/app.php')){
    require_once __DIR__ . '/../Bootstrap/app.php';
}

if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

Config::get("database.host");