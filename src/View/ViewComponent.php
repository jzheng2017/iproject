<?php
namespace EenmaalAndermaal\View;

class ViewComponent extends View {

    public function __construct(string $component)
    {
        $filePath = "components/{$component}";
        parent::__construct($filePath);
    }

    public function render(): string
    {
        return $this->renderBody();
    }
}