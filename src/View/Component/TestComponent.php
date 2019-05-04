<?php
namespace EenmaalAndermaal\View\Component;

use EenmaalAndermaal\Model\TestModel;
use EenmaalAndermaal\View\ViewComponent;

class TestComponent extends ViewComponent {

    public $item;

    public function __construct(TestModel $item)
    {
        $this->item = $item;
        parent::__construct("test");
    }

}