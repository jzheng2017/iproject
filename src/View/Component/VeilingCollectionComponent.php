<?php

namespace EenmaalAndermaal\View\Component;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Model\VeilingModelCollection;
use EenmaalAndermaal\View\ViewComponent;

class VeilingCollectionComponent extends ViewComponent
{

    public $collection;

    /**
     * TestCollectionComponent constructor.
     * @param VeilingModel[] $collection
     */
    public function __construct(VeilingModelCollection $collection)
    {
        $this->collection = $collection;
        parent::__construct("veiling/veiling_collection");
    }
}