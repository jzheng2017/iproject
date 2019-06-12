<?php


namespace EenmaalAndermaal\View;


class CreateVeilingView extends View
{
    public $errors = [];
    public $landen = [];
    public $fields = [];
    public $rubrieken = [];
    public $betaalmethode = ["Bank/Giro", "Contant", "Anders"];
    public $looptijd = [1, 3, 5, 7, 10];
    public $success = false;

    public function __construct()
    {
        parent::__construct("veilingen/veilingen-aanmaken");
        $this->addStyle("style/veiling-aanmaken");
        $this->addScript("scripts/veilingen/veiling-aanmaken");
    }
}