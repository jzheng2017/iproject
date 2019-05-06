<?php
namespace EenmaalAndermaal\View\Component;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\View\ViewComponent;

class VeilingComponent extends ViewComponent {

    public $item;

    public function __construct(VeilingModel $item)
    {
        $this->item = $item;
        parent::__construct("veiling");
    }

}
?>