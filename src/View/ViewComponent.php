<?php

namespace EenmaalAndermaal\View;

class ViewComponent extends View
{

    public function __construct(string $component)
    {
        $filePath = "components/{$component}";
        if (file_exists(BASEPATH . 'views/' . $filePath . ".css")) {
            $this->addStyle('views/' . $filePath);
        }
        if (file_exists(BASEPATH . 'views/' . $filePath . ".js")) {
            $this->addScript('views/' . $filePath);
        }
        parent::__construct($filePath);
    }

    public function render(): string
    {
        return $this->renderBody();
    }
}