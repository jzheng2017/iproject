<?php


namespace EenmaalAndermaal\View;


class ProfileView extends View
{
    public $profile;
    public $veilingen;
    public $geboden;
    public function __construct()
    {
        parent::__construct("user/profile");
        $this->homepage = false;
        $this->addStyle("style/profile");
        $this->addScript("scripts/user/profile");
    }
}