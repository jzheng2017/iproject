<?php

namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Util\Debug;

class VeilingModelCollection extends ModelCollection
{

    public function __construct()
    {
        parent::__construct(new VeilingModel());
    }

    public function getByParent(string $id)
    {
        $apiRequest = new ApiRequest("rubrieken/sub/$id/veilingen", RequestMethod::GET());
        if ($apiRequest->connect()) {
            $this->fromResultSet($apiRequest->getResult());
            return true;
        } else {
            Debug::dump($apiRequest->getError());
            die();
        }
    }

    public function getRelated(string $id)
    {
        $apiRequest = new ApiRequest("veilingen/{$id}/gerelateerd", RequestMethod::GET());
        if ($apiRequest->connect()) {
            $this->fromResultSet($apiRequest->getResult());
            return true;
        } else {
            Debug::dump($apiRequest->getError());
            die();
        }
    }

    public function getByTopParent(string $id)
    {
        $apiRequest = new ApiRequest("rubrieken/$id/veilingen", RequestMethod::GET());
        if ($apiRequest->connect()) {
            $this->fromResultSet($apiRequest->getResult());
            return true;
        } else {
            Debug::dump($apiRequest->getError());
            die();
        }
    }

    public function getTopThree()
    {
        $r = new ApiRequest($this->model->getPath() . "/top3", RequestMethod::GET());
        if ($r->connect()) {
            $this->fromResultSet($r->getResult());
            return true;
        } else {
            Debug::dump($r->getError());
            die();
        }
    }
}