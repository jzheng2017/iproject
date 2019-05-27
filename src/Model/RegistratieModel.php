<?php


namespace EenmaalAndermaal\Model;

class RegistratieModel extends Model
{
    public $fields;

    /**
     * @return string the field used as primary key for the entity
     */
    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }

    /**
     *
     * @return string the start of the API path, for example rubrieken
     */
    protected function getBaseApiPath(): string
    {
        // TODO: Implement getBaseApiPath() method.
    }

    public function validatePassword($pwd)
    {
        $errors = "";

        if (strlen($pwd) < 8) {
            $errors .= "<li>Wachtwoord mag niet korter zijn dan 8 tekens</li>";
        }

        if (!preg_match("#[0-9]+#", $pwd)) {
            $errors .= "<li>Wachtwoord moet minimaal 1 cijfer bevatten</li>";
        }

        if (!preg_match('/[A-Z]/', $pwd)) {
            $errors .= "<li>Wachtwoord moet minimaal 1 hoofdletter bevatten</li>";
        }

        if (!preg_match("/^[^\s]{8,}$/i", $pwd)) {
            $errors .= "<li>Wachtwoord moet minimaal 1 speciale teken bevatten</li>";
        }
        return $errors;
    }


    public function verify()
    {
        $errors = "";
        if ($this->fields['form_submitted']) {
            if (empty($this->fields['vraag'])) {
                $errors .= "<li>Er is geen geheime vraag geselecteerd</li>";
            }
            if (empty($this->fields['geslacht'])) {
                $errors .= "<li>Er is geen geslacht geselecteerd</li>";
            }

            if ($this->fields['email'] !== $this->fields['email2']) {
                $errors .= "<li>Emails komen niet overeen</li>";
            }
            if (!filter_var($this->fields['email'], FILTER_VALIDATE_EMAIL)) {
                $errors .= "<li>Email is incorrect ingevuld</li>";
            }
            if (!filter_var($this->fields['email2'], FILTER_VALIDATE_EMAIL)) {
                $errors .= "<li>Herhaalde email is incorrect ingevuld</li>";
            }

            if (empty($this->fields['wachtwoord2'])) {
                $errors .= "<li>Herhaalde wachtwoord is niet ingevuld</li>";
            } else if ($this->fields['wachtwoord'] !== $this->fields['wachtwoord2']) {
                $errors .= "<li>De wachtwoorden komen niet overeen</li>";
            }
            $errors .= $this->validatePassword($this->fields['wachtwoord']);
        }
        return $errors;
    }


}