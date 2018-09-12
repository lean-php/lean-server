<?php

namespace App;

use App\Controller\HomeController;
use Lean\Http\Request;
use Lean\Http\Response;

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

    /**
     * The main Request - Response - Lifecyle
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $ctrl = new HomeController();
        $ctrl->setContainer($this->container);
        return $ctrl->index();
    }


}