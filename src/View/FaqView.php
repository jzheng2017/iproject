<?php

namespace EenmaalAndermaal\View;


class FaqView extends View
{
    public function __construct()
    {
        parent::__construct("header/faq");
        $this->addStyle("style/faq");
        $this->addScript("scripts/header/faq");
    }
}