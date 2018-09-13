<?php

namespace App\Controller\Admin;

use Lean\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Request;

class DashboardController
{
    use ControllerTrait;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @role(allow="br")
     */
    public function index(Request $request)
    {
        // Security: Authorization Stufe 2 (darf Rolle hier überhaupt sein?)

        return $this->render('admin/dashboard');
    }
}