<?php

namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Util\Debug;

abstract class Model
{

    /**
     * @return string the field used as primary key for the entity
     */
    public abstract function getIdentifier();

    /**
     *
     * @return string the start of the API path, for example rubrieken
     */
    protected abstract function getBaseApiPath(): string;

    public function save(): bool
    {
        /** @var $request ApiRequest */
        $request = null;

        if (empty($identifier)) {
            $request = new ApiRequest($this->getPath(), RequestMethod::POST());
        } else {
            $request = new ApiRequest($this->getPath() . "/" . $this->getIdentifier(), RequestMethod::POST());
        }

        if ($request->connect(get_object_vars($this))) {
            return true;
        } else {
            Debug::dump($request->getError());
            die();
        }
    }

    public function getOne(string $identifier): bool
    {
        $request = new ApiRequest($this->getPath() . "/{$identifier}", RequestMethod::GET());
        if ($request->connect()) {
            if (count($request->getResult()) > 0) {
                $this->map($request->getResult()[0]);
                return true;
            }
        }
        return false;
    }

    public function delete(): bool
    {
        $request = new ApiRequest($this->getPath() . "/" . $this->getIdentifier() . "/delete", RequestMethod::POST());
        if ($request->connect()) {
            return true;
        } else {
            Debug::dump($request->getError());
            die();
        }
    }

    public function getPath()
    {
        $path = $this->getBaseApiPath();
        return $path;
    }

    public function map(array $assocArray)
    {
        foreach ($assocArray as $property => $value) {
            if (property_exists(get_called_class(), $property)) {
                $this->$property = $value;
            }
        }
    }
}