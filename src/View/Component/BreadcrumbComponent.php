<?php

namespace EenmaalAndermaal\View\Component;


use EenmaalAndermaal\View\ViewComponent;

class BreadcrumbComponent extends ViewComponent
{

    public $crumbs;

    public function __construct(array $crumbs)
    {
        $this->crumbs = $crumbs;
        parent::__construct('global/breadcrumbs');
    }
}