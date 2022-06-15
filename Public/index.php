<?php

use ItsPixStore\Config\Config;
use ItsPixStore\Database\Database;

if(file_exists(__DIR__ . '/../Bootstrap/app.php')){
    require_once __DIR__ . '/../Bootstrap/app.php';
}

if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}


$database = new Database();

$database->table('users')
    ->select()
    ->where('username', 'eduubessa')
    ->get();
