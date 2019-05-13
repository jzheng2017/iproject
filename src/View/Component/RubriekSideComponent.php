<?php


namespace EenmaalAndermaal\View\Component;


use EenmaalAndermaal\Model\RubriekModel;
use EenmaalAndermaal\View\ViewComponent;

class RubriekSideComponent extends ViewComponent
{
    /**
     * @var RubriekModel $rubriek
     */
    public $rubriek;
    public $activeId;

    public function __construct(RubriekModel $rubriek, $activeId = 0)
    {
        $this->activeId = $activeId;
        $this->rubriek = $rubriek;
        parent::__construct("rubrieken/sidebar");
    }


}