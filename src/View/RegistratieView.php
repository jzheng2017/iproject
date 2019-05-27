<?php

namespace EenmaalAndermaal\View;


class RegistratieView extends View
{
    public $errors;
    public $fields;
    public function __construct()
    {
        parent::__construct("registreren/registratie");
        $this->addStyle("style/registratie");
        $this->addScript("scripts/registreren/registratie");
    }
}