<?php

namespace EenmaalAndermaal\Model;

use \EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Services\UserService;
use EenmaalAndermaal\Services\ZipcodeService;
use http\Client\Curl\User;

class VeilingModel extends Model
{
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
    public $looptijd;
    public $verkoper;
    public $koper;
    public $beginDag;
    public $beginTijd;
    public $eindDag;
    public $eindTijd;
    public $gesloten;
    public $verkoopPrijs;
    public $parent = [];
    public $weergaves;
    public $thumbnail;
    public $tmpThumbnail;
    public $images = [];
    public $tmpImages = [];
    public $lat;
    public $long;


    public function getValues(): array
    {
        return array(
            "nummer" => $this->nummer,
            "titel" => $this->titel,
            "beschrijvingkort" => $this->beschrijvingKort,
            "beschrijving" => $this->beschrijving,
            "startprijs" => $this->startPrijs,
            "betalingswijze" => $this->betalingsWijze,
            "betalingsinstructie" => $this->betalingsInstructie,
            "plaatsnaam" => $this->plaatsNaam,
            "land" => $this->land,
            "postcode" => $this->postcode,
            "verzendkosten" => $this->verzendKosten,
            "verzendinstructie" => $this->verzendInstructie,
            "verkoper" => $this->verkoper,
            "koper" => NULL,
            "looptijdbegindag" => $this->beginDag,
            "looptijdbegintijdstip" => $this->beginTijd,
            "looptijdeindedag" => $this->eindDag,
            "looptijdeindetijdstip" => $this->eindTijd,
            "veilinggesloten" => false,
            "verkoopprijs" => $this->verkoopPrijs,
            "parent" => $this->parent,
            "thumbnail" => $this->thumbnail,
            "images" => $this->images,
            "lat" => $this->lat,
            "long" => $this->long
        );
    }

    public function setValues()
    {
        $this->setDates();
        $this->calculateLatLong();
        $this->gesloten = '0';
        $this->koper = NULL;
        $this->verkoper = UserService::getInstance()->getCurrentUser()->getIdentifier();
        $this->startPrijs = floor($this->startPrijs * 100);
        $this->verkoopPrijs = $this->startPrijs;
    }

    private function containsSpecialChars($string)
    {
        if (preg_match('/[^a-z0-9 _]+/i', $string)) {
            return true;
        }
        return false;
    }

    public function bind($postVars)
    {
        foreach ($postVars as $key => $var) {
            if (property_exists(get_called_class(), $key)) {
                $this->$key = $var;
            }
        }
    }

    private function calculateLatLong()
    {
        $result = ZipcodeService::getLatLong($this->postcode);
        $this->lat = $result[0];
        $this->long = $result[1];
    }

    private function setStartDate()
    {
        $this->beginDag = date("Y-m-d");
        $this->beginTijd = date("H:i:s");
    }

    private function setEndDate()
    {
        $this->eindDag = Date("Y-m-d", strtotime("+" . $this->looptijd . " days"));
        $this->eindTijd = date("H:i:s");
    }

    private function setDates()
    {
        $this->setStartDate();
        $this->setEndDate();
    }

    private function validateImage($file)
    {
        $valid = true;
        if (!getimagesize($file['tmp_name'])) {
            $valid = false;
        }
        if ($file['size'] > 5000000) {
            $valid = false;
        }
        return $valid;
    }

    private function validateMultipleImages(array $files)
    {
        $valid = true;
        foreach ($files as $file) {
            if (!$this->validateImage($file)) {
                $valid = false;
            }
        }
        return $valid;
    }

    private function validateNumericValues($value)
    {
        $valid = true;
        if (!is_numeric($value)) {
            $valid = false;
        }
        if ($value < 0) {
            $valid = false;
        }
        return $valid;
    }

    public function verify()
    {
        $errors = [];
        if (empty($this->titel)) {
            $errors[] = "Titel is niet ingevuld";
        }
        if (empty($this->beschrijvingKort)) {
            $errors[] = "Korte beschrijving is niet ingevuld";
        } else if (strlen($this->beschrijvingKort) > 255) {
            $errors[] = "De korte beschrijving mag niet hoger zijn dan 255 karakters";
        }

        if (empty($this->verzendKosten) && $this->verzendKosten !== '0') {
            $errors[] = "Verzendkosten is niet ingevuld";
        } else if (!$this->validateNumericValues($this->verzendKosten)) {
            $errors[] = "Verzendkosten is incorrect ingevuld";
        }

        if (empty($this->startPrijs)) {
            $errors[] = "Startprijs is niet ingevuld";
        } else if (!$this->validateNumericValues($this->verzendKosten)) {
            $errors[] = "Startprijs is incorrect ingevuld";
        }
        if (!count($this->betalingsWijze)) {
            $errors[] = "Er is geen betalingsmethode gekozen";
        }
        if (!count($this->parent)) {
            $errors[] = "Er is geen rubriek gekozen";
        } else if (count($this->parent) > 5) {
            $errors[] = "Er mag niet meer dan 5 rubrieken gekozen worden";
        }
        if (empty($this->looptijd)) {
            $errors[] = "Er is geen looptijd gekozen";
        }
        if (empty($this->postcode)) {
            $errors[] = "postcode is niet ingevuld";
        }

        if (empty($this->plaatsNaam)) {
            $errors[] = "Stad is niet ingevuld";
        }
        if ($this->containsSpecialChars($this->plaatsNaam)) {
            $errors[] = "Stad mag geen speciale tekens bevatten";
        }
        if ($this->containsSpecialChars($this->postcode)) {
            $errors[] = "Postcode mag geen speciale tekens bevatten";
        }
        if ($this->tmpThumbnail['size'] <= 0) {
            $errors[] = "Er is geen thumbnail gekozen";
        } else if (!$this->validateImage($this->tmpThumbnail)) {
            $errors[] = "Gekozen thumbnail is niet een afbeelding of is groter dan 5 MB";
        }
        if (count($this->tmpImages) > 4) {
            $errors[] = "Er zijn meer dan 4 afbeeldingen geupload";
        }
        if (!$this->validateMultipleImages($this->tmpImages)) {
            $errors[] = "De geuploade afbeelding is niet een afbeelding of is groter dan 5MB";
        }

        return $errors;
    }

    public static function getHoogsteBieder($id)
    {
        $r = new ApiRequest("veilingen/" . $id . "/biedingen", RequestMethod::GET());
        if ($r->connect()) {
            $result = $r->getResult();
            if (count($result) > 0) {
                return $result[0]['naam'];
            }
        }
        return [];
    }

    public static function getKoperInfo(){
        //$r = new ApiRequest("veilingen/". $)
    }

    public function saveImages()
    {
        $success = true;
        $file = new FileModel();
        if ($file->setFile($this->tmpThumbnail, "")) {
            $this->thumbnail = "upload/" . $file->fileName;
        } else {
            $success = false;
        }
        foreach ($this->tmpImages as $image) {
            if ($file->setFile($image, "")) {
                $this->images[] = "upload/" . $file->fileName;
            } else {
                $success = false;
            }
        }
        return $success;
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