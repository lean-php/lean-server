<?php

return [
    // My custom logger, replaces kernel logger
    'app.logger' => \DI\create(\Monolog\Handler\StreamHandler::class)
        ->constructor(dirname(__DIR__) . '/var/logs/app.log', \Monolog\Logger::INFO),
    \Psr\Log\LoggerInterface::class => DI\create(\Monolog\Logger::class)
        ->constructor('app')
        ->method('pushHandler', DI\get('app.logger')),

    // Default Cache - this is app specific (auch nicht im ControllerTrait)
    \Psr\SimpleCache\CacheInterface::class => DI\create(\Symfony\Component\Cache\Simple\FilesystemCache::class),

    // Default Connection
    \PDO::class => DI\create()->constructor(
        'mysql:host=localhost;dbname=sakila', 'itnrw', 'php', []
    )
];