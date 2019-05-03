<?php

namespace EenmaalAndermaal\View;

class View
{

    private $path;

    private $body;

    private $layout;

    public function __construct($path)
    {
        $this->path = BASEPATH . "views/" . $path . ".phtml";
        $this->setLayout("default");
    }

    public function render(): string
    {
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $this->layout;
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    public function renderComponent(ViewComponent $component)
    {
        return $component->render();
    }

    protected function loadContents()
    {
        if (file_exists($this->path)) {
            ob_start();
            /** @noinspection PhpIncludeInspection */
            include $this->path;
            $this->body = ob_get_contents();
            ob_end_clean();
        } else {
            $this->body = "Content not loaded, check if file exists: " . $this->path;
        }
    }

    protected function setLayout(string $path)
    {
        $this->layout = BASEPATH . "views/layout/$path.phtml";
        if (!file_exists($this->layout)) {
            die("invalid layout path given: {$this->layout}");
        }
    }

    public function renderBody(): string
    {
        if (empty($this->body)) {
            $this->loadContents();
        }
        return $this->body;
    }
}