<?php

namespace EenmaalAndermaal\Util;

class Debug
{

    public static function printPre($var)
    {
        debug_print_backtrace();
        echo "<blockquote><pre>";
        print_r($var);
        echo "</pre></blockquote>";
    }

    public static function dump($var)
    {
        debug_print_backtrace();
        echo "<blockquote><pre>";
        var_dump($var);
        echo "</pre></blockquote>";
    }
}