<?php
namespace EenmaalAndermaal\Request;

class Response {


    private $code;
    private $message;
    private $data;

    public function __construct(int $code, string $message, array $data)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function asJson(): string
    {
        http_response_code($this->code);
        return json_encode([
            "code" => $this->code,
            "message" => $this->message,
            "body" => $this->data
        ]);
    }

    public function __toString()
    {
        return $this->asJson();
    }
}