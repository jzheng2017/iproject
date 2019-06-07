<?php


namespace EenmaalAndermaal\View;


class CreateVeilingView extends View
{
    public $errors = [];
    public $landen = [];
    public $fields = [];
    public $rubrieken = [];
    public $success = false;

    public function __construct()
    {
        parent::__construct("veilingen/veilingen-aanmaken");
        $this->addStyle("style/veiling-aanmaken");
        $this->addScript("scripts/veilingen/veiling-aanmaken");
    }
}