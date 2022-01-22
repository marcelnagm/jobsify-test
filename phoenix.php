<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$ENV = $_ENV['ENV'] ?? 'dev';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');
return [
    'migration_dirs' => [
        'first' => __DIR__ . '/migrations',
    ],
    'environments' => [
        'local' => [
            'adapter' => 'mysql',
            'host' => $_ENV["DB_HOST"],
            'port' => $_ENV["DB_PORT"], // optional
            'username' => $_ENV["DB_USER"],
            'password' => $_ENV["DB_PASSWORD"],
            'charset' => $_ENV["DB_CHARSET"],
            'db_name' => $_ENV["DB_NAME"],
        ],
        'production' => [
            'adapter' => 'mysql',
            'host' => 'production_host',
            'port' => 3306, // optional
            'username' => 'user',
            'password' => 'pass',
            'db_name' => 'my_production_db',
            'charset' => 'utf8mb4',
        ],
    ],
    'default_environment' => 'local',
    'log_table_name' => 'phoenix_log',
];
