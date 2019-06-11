<?php


namespace EenmaalAndermaal\View;


class VerkoperView extends View
{
    public function __construct()
    {
        parent::__construct("header/verkoper");
        $this->addStyle("style/verkoper");
    }
}