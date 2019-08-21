<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'database' => [
                'host' => $_ENV['DB_HOST'] ?? null,
                'name' => $_ENV['DB_NAME'] ?? null,
                'port' => $_ENV['DB_PORT'] ?? null,
                'user' => $_ENV['DB_USER'] ?? null,
                'password' => $_ENV['DB_PASSWORD'] ?? null,
            ]
        ],
    ]);
};
