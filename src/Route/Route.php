<?php

namespace EenmaalAndermaal\Route;

use EenmaalAndermaal\Request\Request;
use EenmaalAndermaal\Request\RequestMethod;
use \Closure;

class Route
{

    /**
     * @var RequestMethod $method
     */
    private $method;

    /**
     * @var string $path
     */
    private $path;

    /**
     * @var Closure $action
     */
    private $action;

    public function __construct(string $path, RequestMethod $method, Closure $action)
    {
        $this->path = $path;
        $this->method = $method;
        $this->action = $action;
    }

    public function match(string $link, RequestMethod $method)
    {
        $pathElements = explode('/', $this->path);
        $inputElements = explode('/', $link);

        if (count($pathElements) !== count($inputElements)) {
            return false;
        }

        foreach ($pathElements as $index => $pathElement) {
            if ($inputElements[$index] == $pathElement) {
                continue;
            } else if (preg_match('^{.*}^', $pathElement) == 0) {
                return false;
            }
        }
        return $method->value === $this->method->value;
    }

    public function call(Request $request)
    {
        $pathElements = explode('/', $this->path);
        $inputElements = explode('/', $request->getLink());
        $args = [];
        foreach ($pathElements as $index => $pathElement) {
            // als het element een variabele is, voeg de variabele toe aan de argumenten
            if (preg_match('^{.*}^', $pathElement)) {
                $args[str_replace(['{', '}'], "", $pathElement)] = $inputElements[$index];
            }
        }
        $request->setVars($args);
        //roep de actie aan met de argumenten uit de url
        return call_user_func($this->action, $request);
    }
}