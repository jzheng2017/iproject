<?php

namespace EenmaalAndermaal\Model;

class VraagModelCollection extends ModelCollection
{
    public function __construct()
    {
        parent::__construct(new VraagModel());
    }
}