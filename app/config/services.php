<?php

return [
    'app.logger' => \DI\create(\Monolog\Handler\StreamHandler::class)
        ->constructor(dirname(__DIR__) . '/var/logs/app.log', \Monolog\Logger::INFO),
    \Psr\Log\LoggerInterface::class => DI\create(\Monolog\Logger::class)
        ->constructor('app')
        ->method('pushHandler', DI\get('app.logger'))
];