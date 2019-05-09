<?php

namespace EenmaalAndermaal\Model;

class RubriekModel extends Model
{

    public $nummer;
    public $naam;
    public $rubriek;
    public $volgnummer;

    /**
     * @var RubriekModelCollection $children
     */
    public $children;

    public function includeChildren($recursive = false)
    {
        $this->getChildren();
        if (!empty($this->getIdentifier())) {
            if ($recursive) {
                $this->children->getAllByParent($this);
                //$this->children->getAllByParentInefficient($this); DO NOT USE THIS!
            } else {
                $this->children->getByParent($this);
            }
        }
    }

    public function getChildren()
    {
        if (empty($this->children)) {
            $this->children = new RubriekModelCollection();
        }
        return $this->children;
    }

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