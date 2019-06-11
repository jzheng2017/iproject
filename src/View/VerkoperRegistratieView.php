<?php


namespace EenmaalAndermaal\View;


use EenmaalAndermaal\Model\LandModelCollection;

class VerkoperRegistratieView extends View
{

    public function __construct()
    {
        parent::__construct("user/verkoperWorden");
        $this->homepage = false;
        $this->addScript("scripts/user/verkoperWorden");
    }
}