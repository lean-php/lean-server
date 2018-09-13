<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
  $r->addRoute('GET', '/', [\App\Controller\HomeController::class, 'index']);

  // Admin Backend
  $r->addGroup('/admin', function (RouteCollector $r) {
      $r->addRoute('GET', '', [\App\Controller\Admin\DashboardController::class, 'index']);
      $r->addRoute('GET', '/customers/no-cache', [\App\Controller\Admin\CustomerController::class, 'nocache']);
      $r->addRoute('GET', '/customers/data-cache', [\App\Controller\Admin\CustomerController::class, 'datacache']);
      $r->addRoute('GET', '/customers/browser-cache', [\App\Controller\Admin\CustomerController::class, 'browsercache']);
      $r->addRoute('GET', '/customers/output-cache', [\App\Controller\Admin\CustomerController::class, 'outputcache']);
  });

  $r->addRoute('GET', 'customer/rentals[/{id}]', [
      '_ctrl' => RentalController::class,
      '_action' => 'index',
      '_roles' => ['cst']
  ]);
  $r->addRoute('GET', 'staff/customer/{id}/rental');
  $r->addRoute('GET', 'admin/staff/{id}/rental');

  $r->addRoute('GET', '{rolle:staff|admin}/rentals[/{id}[/{action}]]');

};
