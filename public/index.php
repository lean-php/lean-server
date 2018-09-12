<?php

require '../vendor/autoload.php';

// Start the engines: the Kernel
$kernel = new \App\Kernel();

$request = new \Lean\Http\Request();
$response = $kernel->handle($request);
$response->send();
