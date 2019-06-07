<?php

namespace EenmaalAndermaal\Services;

class ZipcodeService
{

    static $countries = [
        "DE" => 5,
        "GB" => 3,
        "IT" => 5,
        "MX" => 5,
        "CA" => 3,
        "PL" => 6,
        "FR" => 5,
        "AS" => 5,
        "US" => 5,
        "HK" => 6,
        "CN" => 6
    ];

    static function getCountryZipcodeLength($countryCode)
    {
        if (isset(self::$countries[strtoupper($countryCode)])) {
            return self::$countries[$countryCode];
        } else {
            return 4;
        }
    }

    static function getLatLong($postcode, $land = 'NL'): array
    {
        $checkPostCode = substr($postcode, 0, self::getCountryZipcodeLength($land));
        $location = json_decode(@file_get_contents("http://api.zippopotam.us/{$land}/{$checkPostCode}"), true);
        $lat = 51.985;
        $long = 5.898;
        $result = false;
        if (isset($location['places'][0]['longitude'])) {
            $lat = (float)self::checkBetween($location['places'][0]['latitude'], -90, 90, $lat);
            $long = (float)self::checkBetween($location['places'][0]['longitude'], -90, 90, $long);
            $result = true;
        }
        return [$lat, $long, $result];
    }


    private static function checkBetween($x, $min, $max, $default) {
        if ($x >= $min && $x <= $max) {
            return $x;
        }
        return $default;
    }
}