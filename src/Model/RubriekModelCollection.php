<?php

namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Util\Debug;

class RubriekModelCollection extends ModelCollection
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

    public function getAllByParent(RubriekModel $parent)
    {
        $request = new ApiRequest($parent->getPath() . "/{$parent->getIdentifier()}/allchildren", RequestMethod::GET());
        if ($request->connect()) {
            //array for all children of children
            $subChildren = [];
            foreach ($request->getResult() as $rubriek) {
                /** @var RubriekModel $m */
                $m = clone $this->model;
                $m->map($rubriek);
                //if child is directly related to the parent, add him
                if ($m->rubriek == $parent->getIdentifier()) {
                    $this->models->add($m);
                } else {
                    //if the child is a child of a child, then store it temporarily
                    $subChildren[$m->rubriek][] = $rubriek;
                }
            }
            //loop through all children
            foreach ($this as $model) {
                /** @var RubriekModel $model */
                if (isset($subChildren[$model->getIdentifier()])) {
                    //if the parent is known, add the childrens children
                    $model->children = $model->getChildren()->fromResultSet($subChildren[$model->getIdentifier()]);
                }
            }
            return true;
        } else {
            Debug::dump($request->getError());
            die();
        }
    }

    public function getAllByParentInefficient(RubriekModel $parent)
    {
        $request = new ApiRequest($parent->getPath() . "/{$parent->getIdentifier()}/children", RequestMethod::GET());
        if ($request->connect()) {
            foreach ($request->getResult() as $rubriek) {
                /** @var RubriekModel $m */
                $m = clone $this->model;
                $m->map($rubriek);
                $m->includeChildren(true);
                //if child is directly related to the parent, add it
                $this->models->add($m);
            }
            return true;
        } else {
            Debug::dump($request->getError());
            die();
        }
    }
}