<?php

require '../vendor/autoload.php';

// Start the engines: the Kernel
$kernel = new \App\Kernel(true);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
