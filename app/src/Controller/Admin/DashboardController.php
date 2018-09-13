<?php

namespace App\Controller\Admin;

use Lean\Controller\ControllerTrait;

class DashboardController
{
    use ControllerTrait;

    public function index()
    {
        return $this->render('admin/dashboard');
    }
}