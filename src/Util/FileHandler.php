<?php


namespace EenmaalAndermaal\Util;


class FileHandler
{
    public static function remapMultiFile(array $file)
    {
        return array_map(function ($name, $type, $tmp_name, $error, $size) {
            return array(
                'name' => $name,
                'type' => $type,
                'tmp_name' => $tmp_name,
                'error' => $error,
                'size' => $size,
            );
        }, (array)$file['name'],
            (array)$file['type'],
            (array)$file['tmp_name'],
            (array)$file['error'],
            (array)$file['size']);
    }
}