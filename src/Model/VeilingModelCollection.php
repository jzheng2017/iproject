<?php

namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Util\Debug;

class VeilingModelCollection extends ModelCollection
{

    public function __construct()
    {
        parent::__construct(new RubriekModel());
    }

    public function getByParent(RubriekModel $parent)
    {
        $request = new ApiRequest($parent->getPath() . "/{$parent->getIdentifier()}/children", RequestMethod::GET());
        if ($request->connect()) {
            $this->fromResultSet($request->getResult());
            return true;
        } else {
            Debug::dump($request->getError());
            die();
        }
    }
}