<?php

namespace App\Controller;

use League\Plates\Engine;
use Lean\Controller\ControllerTrait;

class DefaultController
{
    use ControllerTrait;

    /**
     * @return \Lean\Http\Response
     */
    public function index()
    {
        return $this->render('default/index');
    }
}
