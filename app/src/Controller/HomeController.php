<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 12.09.2018
 * Time: 19:26
 */

namespace App\Controller;


use Lean\Controller\ControllerTrait;

class HomeController
{
    use ControllerTrait;

    /**
     * @return \Lean\Http\Response
     */
    public function index()
    {
        return $this->render('home/index');
    }
}
