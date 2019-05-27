<?php
namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\Model\LandModel;

class LandModelCollection extends ModelCollection {
    public function __construct()
    {
        parent::__construct(new LandModel());
    }
}