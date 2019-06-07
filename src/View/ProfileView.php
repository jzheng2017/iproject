<?php


namespace EenmaalAndermaal\View;


use EenmaalAndermaal\Model\LandModelCollection;

class ProfileView extends View
{
    public $profile;
    /** @var LandModelCollection $landen */
    public $landen;
    public $fields = [];
    public function __construct()
    {
        parent::__construct("user/profile");
        $this->homepage = false;
        $this->addStyle("style/profile");
        $this->addScript("scripts/user/profile");
    }
}