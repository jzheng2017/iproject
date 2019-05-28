<?php
namespace EenmaalAndermaal\Model;

class VeilingModel extends Model {
    public $nummer;
    public $titel;
    public $beschrijvingKort;
    public $beschrijving;
    public $startPrijs;
    public $betalingsWijze;
    public $betalingsInstructie;
    public $plaatsNaam;
    public $land;
    public $postcode;
    public $verzendKosten;
    public $verzendInstructie;
    public $verkoper;
    public $koper;
    public $beginDag;
    public $beginTijd;
    public $eindDag;
    public $eindTijd;
    public $gesloten;
    public $verkoopPrijs;
    public $parent;
    public $weergaves;
    public $thumbnail;
    public $images;

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

    /**
     * @return int minimal bid for this auction
     */
    public function getMinBod(): int
    {
        if ($this->verkoopPrijs >= 500000) {
            return $this->verkoopPrijs + 5000;
        }
        if ($this->verkoopPrijs >= 100000) {
            return $this->verkoopPrijs + 1000;
        }
        if ($this->verkoopPrijs >= 50000) {
            return $this->verkoopPrijs + 500;
        }
        if ($this->verkoopPrijs >= 5000) {
            return $this->verkoopPrijs + 100;
        }
        return $this->verkoopPrijs + 50;

    }
}