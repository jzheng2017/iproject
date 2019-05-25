<?php
namespace EenmaalAndermaal\Util;

class StringUtil {

    static function timeDutch(string $time)
    {
        $months = [
            "Jan" => "januari",
            "Feb" => "februari",
            "Mar" => "maart",
            "Apr" => "april",
            "May" => "mei",
            "Jun" => "juni",
            "Jul" => "juli",
            "Aug" => "augustus",
            "Sep" => "september",
            "Oct" => "oktober",
            "Nov" => "november",
            "Dec" => "december"
        ];
        $formatted = date("H:m d M Y", strtotime($time));
        foreach ($months as $key => $month) {
            $formatted = str_replace($key, $month, $formatted);
        }
        return $formatted;
    }

    static function euro(int $cents)
    {
        return "€ " . number_format($cents / 100.0, 2, ",", ".");
    }
}