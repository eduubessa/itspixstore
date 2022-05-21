<?php

if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}


$database = new \ItsPixStore\Database\Database();

$database->table('produtos')
    ->select()
    ->where('name', "NOT LIKE ", "Eduardo")
    ->orWhere('name', "LIKE", "Eduardo")
    ->get();

echo "<br />";

$database->table('posts')
    ->select('posts.id', 'posts.title', 'users.username')
    ->join('users', 'posts.author', '=', 'users.id')
    ->where('posts.slug', "bem-vindo-ao-novo-portal")
    ->get();