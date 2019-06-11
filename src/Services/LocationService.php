<?php


namespace EenmaalAndermaal\Services;


class LocationService
{
    public static function getUserLocation()
    {
        $lat = 0;
        $long = 0;
        if (UserService::getInstance()->userLoggedIn()) {
            list($lat, $long, $result) = ZipcodeService::getLatLong(UserService::getInstance()->getCurrentUser()->postcode, UserService::getInstance()->getCurrentUser()->land);
            if ($result) {
                return [$lat, $long];
            }
        }
        $ip = LoggingService::getClientIp();
        $content = json_decode(@file_get_contents("https://extreme-ip-lookup.com/json/{$ip}"),true);
        if (isset($content['lat'])) {
            return [$content['lat'], $content['lon']];
        }
        return [$lat, $long];
    }
}