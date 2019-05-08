<?php

namespace EenmaalAndermaal\Model;

class RubriekModel extends Model
{

    public $nummer;
    public $naam;
    public $rubriek;
    public $volgnummer;
    /**
     * @return string the field used as primary key for the entity
     */
    public function getIdentifier()
    {
        return $this->nummer;
    }

    /**
     *
     * @return string the start of the API path, for example rubrieken
     */
    protected function getBaseApiPath(): string
    {
        return "rubrieken";
    }
}