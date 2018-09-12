<?php
/**
 * Created by PhpStorm.
 * User: itnrw
 * Date: 12.09.18
 * Time: 10:55
 */

namespace App\Controller;


use Lean\Controller\ControllerTrait;
use Psr\Log\LoggerInterface;

class MMController
{

    use ControllerTrait;

    public function index(string $rolle, int $ags )
    {
       $this->logUserAction('MM Liste von ' .$rolle);

        $kommune = 'Wuppertal mit Rolle ' . $rolle;

        return $this->render('mm/liste', ['kommune' => $kommune, 'ags' => $ags]);
    }

    public function edit(string $rolle, int $ags, int $pnr, $stadt = null)
    {

        $kommune = 'Editieren mit Rolle ' . $rolle . ' und PNR ' .$pnr ;

        return $this->render('mm/liste', ['kommune' => $kommune, 'ags' => $ags]);
    }
}