<?php

namespace EenmaalAndermaal\Services;

use EenmaalAndermaal\Model\GebruikerModel;
use EenmaalAndermaal\Util\Debug;

class UserService
{
    private static $instance;

    public static function getInstance(): UserService
    {
        if (self::$instance == null) {
            self::$instance = new UserService();
        }
        return self::$instance;
    }

    /** @var $user GebruikerModel */
    private $user;

    public function getCurrentUser(): GebruikerModel
    {
        if (empty($this->user->gebruikersnaam)) {
            $this->user->getOne(SessionService::getInstance()->get('userId'));
        }
        return $this->user;
    }

    public function userLoggedIn(): bool
    {
        return strlen($this->getCurrentUsername()) > 0;
    }

    public function logout()
    {
        SessionService::getInstance()->remove('userId');
        self::$instance = null;
    }

    private function __construct()
    {
        $this->user = new GebruikerModel();
    }

    public function getCurrentUsername()
    {
        return empty($this->user->gebruikersnaam) ? SessionService::getInstance()->get('userId') : $this->user->gebruikersnaam;
    }
}