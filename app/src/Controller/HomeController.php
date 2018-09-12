<?php

namespace App\Controller;

use Lean\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    use ControllerTrait;

    /**
     * @return Response
     */
    public function index()
    {
        $this->log('Home Controller');

        return $this->render('home/index');
    }
}
