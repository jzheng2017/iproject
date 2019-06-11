<?php


namespace EenmaalAndermaal\View;


class VoorwaardenView extends View
{
    public function __construct()
    {
        parent::__construct("header/voorwaarden");
        $this->addStyle("style/voorwaarden");
    }
}