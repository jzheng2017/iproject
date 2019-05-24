<?php
namespace EenmaalAndermaal\Model;

class VeilingModel extends Model {
    public $nummer;
    public $titel;
    public $beschrijving;
    public $startPrijs;
    public $betalingsWijze;
    public $betalingsInstructie;
    public $plaatsNaam;
    public $land;
    public $verzendKosten;
    public $verzendInstructie;
    public $weergaves;
    public $postcode;
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
        return $this->nummer;
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