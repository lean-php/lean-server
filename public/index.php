<?php

require '../vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    League\Plates\Engine::class => DI\create()->constructor('../templates', 'phtml')
]);
$container = $builder->build();

$ctrl = $container->get(\App\Controller\DefaultController::class);
if (method_exists($ctrl, 'setContainer')) {
    call_user_func([$ctrl, 'setContainer'], $container);
}

$action = 'index';

$reflectionParams = (new ReflectionObject($ctrl))->getMethod($action)->getParameters();
foreach ($reflectionParams as $param) {
    // Preparing parameter injections
    var_dump($param->getType()->getName());
}

$response = $ctrl->index();
$response->send();
