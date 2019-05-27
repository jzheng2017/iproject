<?php

namespace EenmaalAndermaal\View;


use EenmaalAndermaal\Model\LandModelCollection;
use EenmaalAndermaal\Model\VraagModelCollection;

class RegistratieView extends View
{
    public $errors = [];
    public $submit = false;
    public $fields = [];

    /** @var VraagModelCollection $vragen */
    public $vragen;

    /** @var LandModelCollection $landen */
    public $landen;

    public function __construct()
    {
        parent::__construct("registreren/registratie");
        $this->addStyle("style/registratie");
        $this->addScript("scripts/registreren/registreren");
    }
}