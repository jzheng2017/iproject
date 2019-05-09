<?php
namespace EenmaalAndermaal\Model;

class VeilingModel extends Model {
    public $name;
    public $description;
    public $timer;
    public $price;
    public $image;

    /**
     * @return string the field used as primary key for the entity
     */
    public function getIdentifier()
    {
        return ""; //TODO: return correct field
    }

    /**
     *
     * @return string the start of the API path, for example rubrieken
     */
    protected function getBaseApiPath(): string
    {
        return "veilingen";
    }
}