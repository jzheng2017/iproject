<?php

namespace EenmaalAndermaal\View\Component;


use EenmaalAndermaal\View\ViewComponent;

class BreadcrumbComponent extends ViewComponent
{
    public function __construct()
    {
        parent::__construct('global/breadcrumbs');
    }
}