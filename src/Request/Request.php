<?php
namespace EenmaalAndermaal\Request;

class Request {

    private $get;

    private $post;

    private $method;

    private $body;

    private $link;

    private $vars;

    public function __construct(string $link)
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->method = RequestMethod::getByString($_SERVER['REQUEST_METHOD']);
        $this->body = file_get_contents("php://input");
        //convert json if there is json content.
        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            if ($this->body = json_decode($this->body) === null) {
                die(new Response(400, "Bad request.", [
                    "error" => "invalid json provided"
                ]));
            }
        }
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return RequestMethod
     */
    public function getMethod(): RequestMethod
    {
        return $this->method;
    }

    public function setVars(array $args)
    {
        $this->vars = $args;
    }

    public function getVar(string $name) {
        return isset($this->vars[$name]) ? $this->vars[$name] : false;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }
}