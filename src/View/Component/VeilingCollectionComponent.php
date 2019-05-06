<?php

namespace EenmaalAndermaal\View\Component;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\View\ViewComponent;

class VeilingCollectionComponent extends ViewComponent
{

    public $collection;

    /**
     * TestCollectionComponent constructor.
     * @param VeilingModel[] $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
        parent::__construct("veiling_collection");
    }
}