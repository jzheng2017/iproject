<?php
namespace EenmaalAndermaal\Request;

use EenmaalAndermaal\App;

class ApiRequest {

    private $requestMethod;

    private $path;

    private $result;

    private $error;

    public function __construct(string $path, RequestMethod $requestMethod)
    {
        $this->path = strtr(urlencode($path), ['%2F' => "/"] );
        $this->requestMethod = $requestMethod;
    }

    public function connect(array $data = []): bool
    {
        $link = App::getApp()->getConfig()->get("API.url") . $this->path;
        $curl = curl_init($link);

        $header = [];

        $header[] = "api-key:"  .App::getApp()->getConfig()->get("API.key");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->requestMethod);

        if (count($data)) {
            $header[] = 'Content-Type:application/json';
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

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