<?php

namespace EenmaalAndermaal\Services;

use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Request\Response;

class LoggingService
{

    public static function log($route, $data = [])
    {
        $ip = self::getClientIp();
        $gebruiker = UserService::getInstance()->getCurrentUsername();
        $log = [
            "gebruiker" => $gebruiker ? $gebruiker : null,
            "ip" => $ip,
            "data" => json_encode([
                "data" => $data
            ]),
            "route" => $route
        ];
        $r = new ApiRequest("logs", RequestMethod::POST());
        if ($r->connect($log)) {
            return true;
        } else {
            die(new Response(500, "Server error", [
                "message" => "Error connecting to the status services... please try again",
                "error" => $r->getError()
            ]));
        }
    }

    public static function getClientIp()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

}