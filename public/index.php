<?php

require '../vendor/autoload.php';

// Start the engines: the Kernel
$kernel = new \App\Kernel();

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
