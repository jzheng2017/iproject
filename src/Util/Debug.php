<?php

namespace EenmaalAndermaal\Util;

class Debug
{

    public static function printPre($var)
    {
        echo "<blockquote><pre>";
        print_r($var);
        echo "</pre></blockquote>";
    }

    public static function dump($var)
    {
        echo "<blockquote><pre>";
        var_dump($var);
        echo "</pre></blockquote>";
    }
}