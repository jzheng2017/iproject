<?php


namespace EenmaalAndermaal\View;


/**
 * @method addStyle(string $string)
 */

class VerificatieView extends View
{
    public $verificatie;

    public function __construct()
    {
        parent::__construct("verificatie/verifieren");
        $this->addStyle("style/verificatie");
    }
}