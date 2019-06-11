<?php

namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\App;
use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Util\Debug;

class VeilingModelCollection extends ModelCollection
{

    public function __construct()
    {
        parent::__construct(new VeilingModel());
    }

    public function getByParent(string $id, $params = [])
    {
        $apiRequest = new ApiRequest("rubrieken/sub/$id/veilingen", RequestMethod::GET(), $params);
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

    public function getByTopParent(string $id, $params = [])
    {
        $apiRequest = new ApiRequest("rubrieken/$id/veilingen", RequestMethod::GET(), $params);
        if ($apiRequest->connect()) {
            $this->fromResultSet($apiRequest->getResult());
            return true;
        } else {
            Debug::dump($apiRequest->getError());
            die();
        }
    }

    public function search(array $params = [])
    {
        $r = new ApiRequest($this->model->getPath(), RequestMethod::GET(), $params);
        if ($r->connect()) {
            $this->fromResultSet($r->getResult());
            return true;
        } else {
            Debug::dump($r->getError());
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

    public function getNearby($lat, $long)
    {
        $r = new ApiRequest($this->model->getPath() . "/near", RequestMethod::GET(), [
            "lat" => $lat,
            "long" => $long
        ]);
        if ($r->connect()) {
            $this->fromResultSet($r->getResult());
            return true;
        } else {
            Debug::dump($r->getError());
            die();
        }
    }
}