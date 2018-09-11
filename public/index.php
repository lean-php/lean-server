<?php

require '../vendor/autoload.php';

$ctrl = new \App\Controller\DefaultController();
$response = $ctrl->index();
$response->send();
