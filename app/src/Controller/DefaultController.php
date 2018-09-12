<?php

namespace App\Controller;

use League\Plates\Engine;
use Lean\Controller\ControllerTrait;
use Psr\Log\LoggerInterface;

class DefaultController
{
    use ControllerTrait;

    public function __construct()
    {

    }

    /**
     * @return \Lean\Http\Response
     */
    public function index()
    {
        $this->log->info('Default Controller Constructed');
        var_dump('Rolle ' . $this->getRouteParam('rolle'));
        
        return $this->render('default/index');
    }
}
