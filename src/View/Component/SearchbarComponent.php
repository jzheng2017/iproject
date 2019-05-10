<?php

namespace EenmaalAndermaal\View\Component;

use EenmaalAndermaal\Model\RubriekModelCollection;
use EenmaalAndermaal\View\ViewComponent;

class SearchbarComponent extends ViewComponent
{

    public $collection;

    public function __construct()
    {
        $collection = new RubriekModelCollection();
        $collection->getTop();
        foreach ($collection as $rubriek) {
            $rubriek->includeChildren(true);
        }
        $this->collection = $collection;
        parent::__construct("global/searchbar");
    }


}