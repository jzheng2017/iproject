<?php

namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Util\Debug;

class GebruikerModel extends Model
{
    public $gebruikersnaam;
    public $voornaam;
    public $achternaam;
    public $adres;
    public $adresAanvulling;
    public $postcode;
    public $plaatsnaam;
    public $land;
    public $geboortedatum;
    public $email;
    protected $email2;
    public $telefoonnummer;
    public $wachtwoord;
    public $vraag;
    public $antwoordvraag;
    public $permissie;
    public $verificatie;
    protected $wachtwoord2;

    public function bind($postVars)
    {
        foreach ($postVars as $key => $var) {
            if (property_exists(get_called_class(), $key)) {
                $this->$key = $var;
            }
        }
    }

    private function validatePassword($pwd): array
    {
        $errors = [];

        if (strlen($pwd) < 8) {
            $errors[] = "Wachtwoord mag niet korter zijn dan 8 tekens";
        }

        if (!preg_match("#[0-9]+#", $pwd)) {
            $errors[] = "Wachtwoord moet minimaal 1 cijfer bevatten";
        }

        if (!preg_match('/[A-Z]/', $pwd)) {
            $errors[] = "Wachtwoord moet minimaal 1 hoofdletter bevatten";
        }

        if (!preg_match("/^[^\s]{8,}$/i", $pwd)) {
            $errors[] = "Wachtwoord moet minimaal 1 speciaal teken bevatten";
        }

        if (count($errors) < 1) {
            $this->wachtwoord = password_hash($pwd, PASSWORD_DEFAULT);
        }
        return $errors;
    }

    public function save(): bool
    {
        $request = new ApiRequest($this->getPath(), RequestMethod::POST());
        $this->geboortedatum = date('Y-m-d', strtotime($this->geboortedatum));
        if ($request->connect(json_decode(json_encode($this), true))) {
            return true;
        } else {
            Debug::printPre($request);
            return false;
        }
    }

    private function gebruikerExists()
    {
        $r = new ApiRequest("gebruikers/gebruikersnaam/{$this->gebruikersnaam}/exists", RequestMethod::GET());
        $r->connect();
        return $r->getResult()['result'];
    }

    private function containsSpecialChars($string){
        if (preg_match('/[^a-z0-9 _]+/i', $string))
        {
           return true;
        }
        return false;
    }

    private function emailExists()
    {
        $r = new ApiRequest("gebruikers/email/{$this->email}/exists", RequestMethod::GET());
        $r->connect();
        return $r->getResult()['result'];
    }

    public function getToken(): string
    {
        $r = new ApiRequest("gebruikers/{$this->gebruikersnaam}/token", RequestMethod::GET());
        $r->connect();
        return $r->getResult()['token'];
    }

    private function verify(): array
    {
        $errors = [];
        if (empty($this->vraag)) {
            $errors[] = "Er is geen geheime vraag geselecteerd";
        }
        if (empty($this->antwoordvraag)) {
            $errors[] = "Geen antwoord gegeven op de geheime vraag";
        }

        if (empty($this->voornaam)) {
            $errors[] = "Geen voornaam ingevoerd";
        }
        if (empty($this->achternaam)) {
            $errors[] = "Geen achternaam ingevoerd";
        }

        if (empty($this->gebruikersnaam)) {
            $errors[] = "Geen gebruikersnaam gekozen";
        } else if ($this->gebruikerExists()) {
            $errors[] = "Gebruikersnaam bestaat al";
        }

        if (empty($this->land)) {
            $errors[] = "Geen land gekozen";
        }

        if (empty($this->plaatsnaam)) {
            $errors[] = "Geen plaatsnaam ingevoerd";
        }else if ($this->containsSpecialChars($this->plaatsnaam)){
            $errors[] = "Plaatsnaam mag geen speciale karakters bevatten";
        }

        if (empty($this->postcode)){
            $errors[] = "Geen postcode ingevoerd";
        }else if($this->containsSpecialChars($this->postcode)){
            $errors[] = "Postcode mag geen speciale karakters bevatten";
        }

        if (empty(($this->adres))) {
            $errors[] = "Geen adres ingevoerd";
        }
        else if($this->containsSpecialChars($this->adres)){
            $errors[] = "Adres mag geen speciale karakters bevatten";
        }

        if ($this->containsSpecialChars($this->adresAanvulling)){
            $errors[] = "Adres aanvulling mag geen speciale karakters bevatten";
        }

        if (empty($this->telefoonnummer)) {
            $errors[] = "Geen telefoonnummer ingevoerd";
        }

        if ($this->email !== $this->email2) {
            $errors[] = "Emails komen niet overeen";
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is incorrect ingevuld";
        } else if ($this->emailExists()) {
            $errors[] = "Emailadres is al bekend";
        }

        if (empty($this->wachtwoord)) {
            $errors[] = "Herhaalde wachtwoord is niet ingevuld";
        } else if ($this->wachtwoord !== $this->wachtwoord2) {
            $errors[] = "De wachtwoorden komen niet overeen";
        }
        $errors = array_merge($this->validatePassword($this->wachtwoord), $errors);
        return $errors;
    }

    public function validate(): array
    {
        return $this->verify();
    }

    /**
     * @return string the field used as primary key for the entity
     */
    public function getIdentifier()
    {
        return $this->gebruikersnaam;
    }

    /**
     *
     * @return string the start of the API path, for example rubrieken
     */
    protected function getBaseApiPath(): string
    {
        return "gebruikers";
    }

    public function map(array $assocArray)
    {
        foreach ($assocArray as $key => $value) {
            if ($key == 'geboortedatum') {
                $assocArray[$key] = date("d-m-Y", strtotime($value));
            }
        }
        parent::map($assocArray); // TODO: Change the autogenerated stub
    }
}