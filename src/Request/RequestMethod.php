<?php

namespace EenmaalAndermaal\Request;

use EenmaalAndermaal\Util\Enum;

/**
 * Class RequestMethod
 * @method static RequestMethod GET()
 * @method static RequestMethod PUT()
 * @method static RequestMethod POST()
 * @method static RequestMethod DELETE()
 * @package API\Request
 */
class RequestMethod extends Enum
{
    const GET = 'GET';
    const PUT = 'PUT';
    const POST = 'POST';
    const DELETE = 'DELETE';

    public static function getByString(string $method): RequestMethod {
        switch (strtoupper($method)) {
            case 'GET':     return self::GET();
            case 'PUT':     return self::PUT();
            case 'POST':    return self::POST();
            case 'DELETE':  return self::DELETE();
            default:        return self::GET();
        }
    }
}