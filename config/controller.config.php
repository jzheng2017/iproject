<?php

use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\RubriekenController;
use EenmaalAndermaal\Controller\VeilingController;
use EenmaalAndermaal\Controller\ZoekResultaatController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class,
            VeilingController::class,
            ZoekResultaatController::class
        ]
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];