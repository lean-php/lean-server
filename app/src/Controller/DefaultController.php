<?php

namespace App\Controller;

class DefaultController
{
    /**
     * @return \Lean\Http\Response
     */
    public function index()
    {
        return $response = new \Lean\Http\Response('<body><h1>FlüAG</h1></body>');
    }
}