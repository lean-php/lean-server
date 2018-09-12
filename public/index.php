<?php

require '../vendor/autoload.php';

const IS_DEBUG_ENABLED = true;

//
// Configure Container
//
$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    League\Plates\Engine::class => DI\create()->constructor('../templates', 'phtml')
]);
$container = $builder->build();

//
// Configure Routing
//
$dispatcher = FastRoute\cachedDispatcher(function(FastRoute\RouteCollector $r) {
    // Thirs param as you like: string, array, object
    $r->addRoute('GET', '/', [\App\Controller\DefaultController::class, 'index']);
    $r->addRoute('GET', '/{rolle}', [\App\Controller\DefaultController::class, 'index']);
    $r->addRoute('GET', '/{rolle}/kommune', [\App\Controller\DefaultController::class, 'index']);
    $r->addRoute('GET', '/{rolle}/kommune/{ags}/{controller}[/{action}]', [\App\Controller\DefaultController::class, 'index']);
}, [
    'cacheFile' => dirname(__DIR__) . '/var/route.cache', /* required */
    'cacheDisabled' => IS_DEBUG_ENABLED,     /* optional, enabled by default */
]);

//
// Request/Response Cycle
//
$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
var_dump($route); exit();

$ctrl = $container->get($route[1][0]);
if (method_exists($ctrl, 'setContainer')) {
    call_user_func([$ctrl, 'setContainer'], $container);
}

$action = $route[1][1];

$reflectionParams = (new ReflectionObject($ctrl))->getMethod($action)->getParameters();
foreach ($reflectionParams as $param) {
    // Preparing parameter injections
    var_dump($param->getType()->getName());
}

$response = call_user_func([$ctrl, $action], []);
$response->send();
