<?php
/**
 * Created by PhpStorm.
 * User: itnrw
 * Date: 12.09.18
 * Time: 15:02
 */

namespace App\Controller;


use Lean\Controller\ControllerTrait;
use Lean\Http\Response;

class CachedController
{
    use ControllerTrait;

    public function demo()
    {
        $response = $this->render('caching/demo', ['zeit' => date('d.m.Y H:i:s')]);
        $response->addHeader('Cache-Control',['no-cache','max-age=30']);
        return $response;
    }
}