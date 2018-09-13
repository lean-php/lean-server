<?php

namespace App;

use App\Controller\HomeController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel extends \Lean\Kernel
{
    /**
     * Returns the project folder for plates engine
     *
     * @return null|string
     */
    public function getRootFolder(): ?string
    {
        return dirname(__DIR__);
    }
}