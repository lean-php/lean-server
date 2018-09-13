<?php

require '../vendor/autoload.php';

$debug = true;
Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT);

// Start the engines: the Kernel
$kernel = new \App\Kernel($debug);
$cachingKernel = new \Lean\CachingKernel($kernel);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$response = $cachingKernel->handle($request);

$response->send();
