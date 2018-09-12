<?php

require '../vendor/autoload.php';

const IS_DEBUG_ENABLED = true;

//
// Configure Container
//
$builder = new DI\ContainerBuilder();
$builder->addDefinitions([

    Psr\SimpleCache\CacheInterface::class => DI\create(\Symfony\Component\Cache\Simple\FilesystemCache::class),

    'user.streams' => [
        DI\get(\Monolog\Handler\BrowserConsoleHandler::class)
    ],
    'user.log' => DI\create(Monolog\Logger::class)->constructor(
        'user', DI\get('user.streams')
    ),

    'kernel.stream' => DI\create(\Monolog\Handler\StreamHandler::class)
        ->constructor('../var/logs/kernel.log', \Monolog\Logger::INFO),
    \Psr\Log\LoggerInterface::class => DI\create(Monolog\Logger::class)->constructor('kernel')
        ->method('pushHandler', DI\get('kernel.stream') ),
    League\Plates\Engine::class => DI\create()->constructor('../templates', 'phtml')
]);
$container = $builder->build();

//
// Configure Routing
//
$dispatcher = FastRoute\cachedDispatcher(function(FastRoute\RouteCollector $r) {
    // Third param as you like: string, array, object
    $r->addRoute('GET', '/', [\App\Controller\DefaultController::class, 'index']);
    $r->addRoute('GET', '/{rolle}', [\App\Controller\DefaultController::class, 'index']);
    $r->addRoute('GET', '/{rolle}/kommune', [\App\Controller\DefaultController::class, 'index']);
    $r->addRoute('GET', '/{rolle}/kommune/{ags}/mm[/{action}[/{pnr}]]', [\App\Controller\MMController::class, 'index']);
    $r->addRoute('GET', '/kommune/mm[/{action}[/{pnr}]]', [\App\Controller\MMController::class, 'index']);
}, [
    'cacheFile' => dirname(__DIR__) . '/var/route.cache', /* required */
    'cacheDisabled' => IS_DEBUG_ENABLED,     /* optional, enabled by default */
]);

//
// Request/Response Cycle
//
$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

if( $route[0] === FastRoute\Dispatcher::NOT_FOUND ) {
    $response = new \Lean\Http\Response('<h1>Ups, lost in space</h1>', 404);
    $response->send();
    exit();
}

$ctrl = $container->get($route[1][0]);
if (method_exists($ctrl, 'setContainer')) {
    call_user_func([$ctrl, 'setContainer'], $container);
}

$action = $route[2]['action'] ?? $route[1][1];

$container->set('route', DI\value($route[2]));

$reflectionParams = (new ReflectionObject($ctrl))->getMethod($action)->getParameters();
$routeParams = $route[2];
$args = [];
foreach ($reflectionParams as $param) {
    if (array_key_exists($param->name, $routeParams)) {
        $args[] = $routeParams[$param->name];
    } elseif (false) {
        // Lookup in Container
    } elseif (false) {
        // Lookup in Session
    } elseif (isset($_GET[$param->name])) {
        // Lookup in Request
        $args[] = $_GET[$param->name];
    }
}

$response = call_user_func_array([$ctrl, $action], $args);
$response->send();
