<?php


namespace EenmaalAndermaal\View\Component;
use EenmaalAndermaal\Model\RubriekModelCollection;
use EenmaalAndermaal\View\ViewComponent;

class RubriekNavbarComponent extends ViewComponent
{
    public $collection;

    public function __construct()
    {
        $this->collection = new RubriekModelCollection();
        $this->collection->getTop();
        parent::__construct("rubrieken/navbar");
    }


}