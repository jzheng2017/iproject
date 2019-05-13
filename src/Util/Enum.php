<?php

namespace EenmaalAndermaal\Util;
use ReflectionClass;
use ReflectionException;
abstract class Enum
{
    private static $constCacheArray = NULL;

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    private static function getConstants()
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            try {
                $reflect = new ReflectionClass($calledClass);
            } catch (ReflectionException $e) {
                die($e);
            }
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false)
    {
        $constants = static::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(static::getConstants());
        return in_array($value, $values, $strict);
    }

    public static function __callStatic($name, $arguments): Enum
    {
        if (static::isValidName($name)) {
            return new static(static::getConstants()[$name]);
        }
    }

    public function __toString(): String
    {
        return (string) $this->value;
    }
}