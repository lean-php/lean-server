<?php

namespace App\Controller;

use League\Plates\Engine;

class DefaultController
{
    /**
     * @var Engine
     */
    protected $plates;

    /**
     * DefaultController constructor.
     * @param Engine $plates
     */
    public function __construct(Engine $plates)
    {
        $this->plates = $plates;
    }

    /**
     * @return \Lean\Http\Response
     */
    public function index()
    {
        return $response = new \Lean\Http\Response($this->plates->render('default/index'));
    }
}