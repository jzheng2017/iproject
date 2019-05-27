<?php

namespace EenmaalAndermaal\Model;

class LandModel extends Model
{

    public $landcode;

    public $naam;

    /**
     * @return string the field used as primary key for the entity
     */
    public function getIdentifier()
    {
        $this->landcode;
    }

    /**
     *
     * @return string the start of the API path, for example rubrieken
     */
    protected function getBaseApiPath(): string
    {
        return "landen";
    }
}