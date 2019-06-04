<?php

namespace EenmaalAndermaal\Request;

use EenmaalAndermaal\App;
use EenmaalAndermaal\Services\UserService;
use http\Client\Curl\User;

class ApiRequest
{

    private $requestMethod;

    private $path;

    private $result;

    private $error;

    public function __construct(string $path, RequestMethod $requestMethod, $params = [])
    {
        $this->path = strtr(urlencode($path), ['%2F' => "/"]) . (count($params) > 0 ? "?" . http_build_query($params) : "");
        $this->requestMethod = $requestMethod;
    }

    public function connect(array $data = []): bool
    {
        $link = App::getApp()->getConfig()->get("API.url") . $this->path;
        $curl = curl_init($link);

        $header = [];

        $header[] = "api-key:" . App::getApp()->getConfig()->get("API.key");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->requestMethod);

        if (count($data) || $this->requestMethod == RequestMethod::POST()) {
            $header[] = 'Content-Type:application/json';
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        if (UserService::getInstance()->userLoggedIn()) {
            $header[] = 'Username:' . UserService::getInstance()->getCurrentUsername();
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
            $this->result = json_decode($result, true)['body'];
            return true;
        } else {
            $this->error = json_decode($result, true);
            return false;
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}