<?php


namespace EenmaalAndermaal\View;


class ZoekResultaatView extends View
{
    public $zoekresultaat;

    public function __construct()
    {
        parent::__construct("zoekresultaat/zoekresultaat");
        $this->addStyle("style/zoekresultaat");
        $this->addScript("scripts/zoekresultaat/zoekresultaat");
    }
}