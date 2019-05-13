<?php

namespace EenmaalAndermaal\View;

use EenmaalAndermaal\Model\VeilingModel;

class VeilingDetailView extends View
{

    public $veiling;

    public function __construct(VeilingModel $veiling)
    {
        parent::__construct("veilingen/veiling_detail");
        $this->veiling = $veiling;
        $this->homepage = false;
        $this->addStyle("style/veilingen");
        $this->addScript("scripts/veilingen/veiling_detail");
    }
}