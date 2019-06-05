<?php

namespace EenmaalAndermaal\View;

use EenmaalAndermaal\Model\VeilingModel;
use EenmaalAndermaal\Model\VeilingModelCollection;

class VeilingDetailView extends View
{

    public $veiling;
    public $collection;
    public $feedback;
    public $userFeedback;

    public function __construct(VeilingModel $veiling)
    {
        parent::__construct("veilingen/veiling_detail");
        $this->veiling = $veiling;
        $this->homepage = false;
        $this->collection = new VeilingModelCollection();
        $this->collection->getRelated($veiling->getIdentifier());
        $this->addStyle("style/veilingen");
        $this->addScript("scripts/veilingen/veiling_detail");
    }

}