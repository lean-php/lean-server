<?php

require '../vendor/autoload.php';

$container = new DI\Container();

$ctrl = $container->get(\App\Controller\DefaultController::class);
$response = $ctrl->index();
$response->send();
