<?php

namespace EenmaalAndermaal\View\Component;

use EenmaalAndermaal\Model\TestModel;
use EenmaalAndermaal\View\ViewComponent;

class TestCollectionComponent extends ViewComponent
{

    public $collection;

    /**
     * TestCollectionComponent constructor.
     * @param TestModel[] $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
        parent::__construct("test_collection");
    }
}