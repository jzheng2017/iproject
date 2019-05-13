<?php
namespace EenmaalAndermaal\Model;

class VeilingModel extends Model {
    public $nummer;
    public $titel;
    public $beschrijving;
    public $startPrijs;
    public $betalingswijze;
    public $betalingsInstructie;
    public $plaats;
    public $land;
    public $verzendKosten;
    public $verzendInstructie;
    public $verkoper;
    public $koper;
    public $beginDag;
    public $beginTijd;
    public $eindDag;
    public $eindTijd;
    public $gesloten;
    public $prijs;

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