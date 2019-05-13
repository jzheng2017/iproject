<?php
namespace EenmaalAndermaal\View\Component;
use EenmaalAndermaal\Model\RubriekModelCollection;
use EenmaalAndermaal\View\ViewComponent;

class SidenavComponent extends ViewComponent
{
    public $collection;

    public $homepage;

    public function __construct($homepage = false)
    {
        parent::__construct("rubrieken/sidenav");
        $this->collection = new RubriekModelCollection();
        $this->collection->getTop();
        $this->homepage = $homepage;
    }


}