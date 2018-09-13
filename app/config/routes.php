<?php

return function (\FastRoute\RouteCollector $r) {
  $r->addRoute('GET', '/', [\App\Controller\HomeController::class, 'index']);
};
