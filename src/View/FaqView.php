<?php

namespace EenmaalAndermaal\View;


class FaqView extends View
{
    public function __construct()
    {
        parent::__construct("faq/faq");
        $this->addStyle("style/faq");
        $this->addScript("scripts/faq/faq");
    }
}