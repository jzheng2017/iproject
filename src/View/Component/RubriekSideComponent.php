<?php


namespace EenmaalAndermaal\View\Component;


use EenmaalAndermaal\View\ViewComponent;

class RubriekSideComponent extends ViewComponent
{
    public $sidebar;
    public $activeId;

    public function __construct(array $sidebar, $activeId = 0)
    {
        $this->activeId = $activeId;
        $this->sidebar = $sidebar;
        parent::__construct("rubrieken/sidebar");
    }


}