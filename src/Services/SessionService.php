<?php
/**
 * Copyright Mojiweb (c) 2018.
 * CCP CORE FRAMEWORK.
 * Framework can only be used for MojiWeb V.o.F. related projects and with written consent
 * by MojiWeb V.o.F., with the exception of Educational purposes. Re-use, copying or
 * implementation in projects outside of Educational environments is prohibited. Commercial
 * use outside of the MojiWeb V.o.F. organisation is not allowed.
 *
 */

namespace EenmaalAndermaal\Services;

class SessionService
{

    private static $instance;

    function __construct()
    {
        self::sessionStart();
    }

    /**
     *
     * @return SessionService session instance
     */
    public static function getInstance(): SessionService
    {
        if (!self::$instance) {
            self::$instance = new SessionService();
        }

        return self::$instance;
    }

    public function get($index)
    {
        if (!isset($_SESSION)) return false;
        if (!empty($index) && !empty ($_SESSION)) {
            if (isset($_SESSION[$index])) {
                return $_SESSION[$index];
            }
        }
        return false;
    }

    public function set($index, $value)
    {
        if (!isset($_SESSION)) return false;
        if (!empty($index)) {
            $_SESSION[$index] = $value;
            return true;
        }
        return false;
    }

    public function remove($index)
    {
        if (!isset($_SESSION)) return false;
        if (!empty($index) && !empty ($_SESSION)) {
            if (isset($_SESSION[$index]))
                $value = $_SESSION[$index];
            unset($_SESSION[$index]);
            unset($index);
            return $value;
        }
        return false;
    }

    public function delete($index)
    {
        if (!isset($_SESSION)) return false;
        if (!empty($index) && !empty ($_SESSION)) {
            if (isset($_SESSION[$index]))
                unset($_SESSION[$index]);
            unset($index);
            return true;
        }
        return false;
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
    }

    static function sessionStart()
    {
        session_start();
    }

    static protected function validateSession()
    {
        if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']))
            return false;

        if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
            return false;

        return true;
    }

    static protected function preventHijacking()
    {
        if (!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
            return false;

        if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
            return false;

        if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
            return false;

        return true;
    }

    static function regenerateSession()
    {
        // If this session is obsolete it means there already is a new id
        if (isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true)
            return;

        // Set current session to expire in 10 seconds
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + 10;

        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        session_start();

        // Now we unset the obsolete and expiration values for the session we want to keep
        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }
}