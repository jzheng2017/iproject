<?php

use EenmaalAndermaal\Controller\IndexController;
use EenmaalAndermaal\Controller\LegalController;
use EenmaalAndermaal\Controller\RubriekenController;
use EenmaalAndermaal\Controller\VeilingController;

return [
    "dev" => [
        "controllers" => [
            IndexController::class,
            RubriekenController::class,
            VeilingController::class,
            LegalController::class
        ]
    ],
    "production" => [
        "controllers" => [
            IndexController::class,
        ]
    ]
];